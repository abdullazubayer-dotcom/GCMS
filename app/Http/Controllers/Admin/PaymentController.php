<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePaymentRequest;
use App\Http\Requests\Admin\UpdatePaymentRequest;
use App\Models\Event;
use App\Models\Member;
use App\Models\Payment;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $payments = Payment::query()
            ->with(['member.user', 'event', 'receiver'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('payment_no', 'like', "%{$search}%")
                        ->orWhere('payment_type', 'like', "%{$search}%")
                        ->orWhereHas('member', fn ($query) => $query->where('member_code', 'like', "%{$search}%"))
                        ->orWhereHas('member.user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('payment_status'), function ($query) use ($request) {
                $query->where('payment_status', $request->string('payment_status')->toString());
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.payments.index', [
            'payments' => $payments,
            'filters' => $request->only(['search', 'payment_status']),
        ]);
    }

    public function create(): View
    {
        return view('admin.payments.create', $this->formData());
    }

    public function store(StorePaymentRequest $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $data = $request->validated();
        $data['payment_no'] = $this->generatePaymentNo();

        $payment = Payment::create($data);

        $activityLogger->log(
            'create',
            'payment',
            "Created payment {$payment->payment_no}.",
            $payment,
            null,
            $payment->toArray()
        );

        return redirect()
            ->route('admin.payments.show', $payment)
            ->with('status', 'Payment recorded successfully.');
    }

    public function show(Payment $payment): View
    {
        $payment->load(['member.user', 'event', 'receiver', 'updater']);

        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment): View
    {
        return view('admin.payments.edit', array_merge(
            ['payment' => $payment],
            $this->formData()
        ));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment, ActivityLogger $activityLogger): RedirectResponse
    {
        $oldValues = $payment->toArray();

        $payment->update([
            ...$request->validated(),
            'updated_by' => Auth::id(),
        ]);

        $activityLogger->log(
            'update',
            'payment',
            "Updated payment {$payment->payment_no}.",
            $payment,
            $oldValues,
            $payment->fresh()->toArray()
        );

        return redirect()
            ->route('admin.payments.show', $payment)
            ->with('status', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment, ActivityLogger $activityLogger): RedirectResponse
    {
        $oldValues = $payment->toArray();
        $paymentNo = $payment->payment_no;
        $payment->delete();

        $activityLogger->log(
            'delete',
            'payment',
            "Deleted payment {$paymentNo}.",
            $payment,
            $oldValues
        );

        return redirect()
            ->route('admin.payments.index')
            ->with('status', 'Payment deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(): array
    {
        return [
            'members' => Member::with('user')->orderBy('member_code')->get(),
            'events' => Event::orderByDesc('event_date')->get(),
            'receivers' => User::with('role')
                ->where('status', 'active')
                ->whereHas('role', fn ($query) => $query->whereIn('name', ['super_admin', 'admin']))
                ->orderBy('name')
                ->get(),
        ];
    }

    private function generatePaymentNo(): string
    {
        $prefix = 'PAY-'.now()->format('Ymd');
        $nextNumber = Payment::where('payment_no', 'like', "{$prefix}-%")->count() + 1;

        do {
            $paymentNo = $prefix.'-'.str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
            $nextNumber++;
        } while (Payment::where('payment_no', $paymentNo)->exists());

        return $paymentNo;
    }
}
