<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePaymentRequest;
use App\Http\Requests\Admin\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['member.user.role', 'event', 'receiver.role'])
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();
                $query->where(fn ($query) => $query->where('payment_no', 'like', "%{$search}%")
                    ->orWhere('payment_type', 'like', "%{$search}%")
                    ->orWhereHas('member', fn ($query) => $query->where('member_code', 'like', "%{$search}%")));
            })
            ->when($request->filled('payment_status'), fn ($query) => $query->where('payment_status', $request->string('payment_status')))
            ->when($request->filled('member_id'), fn ($query) => $query->where('member_id', $request->integer('member_id')))
            ->latest()->paginate(min($request->integer('per_page', 15), 100))->withQueryString();

        return PaymentResource::collection($payments);
    }

    public function store(StorePaymentRequest $request, ActivityLogger $logger): JsonResponse
    {
        $data = $request->validated();
        $data['payment_no'] = $this->generatePaymentNo();
        $payment = Payment::create($data);
        $logger->log('create', 'payment', "Created payment {$payment->payment_no}.", $payment, null, $payment->toArray());

        return (new PaymentResource($payment->load(['member.user.role', 'event', 'receiver.role'])))->response()->setStatusCode(201);
    }

    public function show(Payment $payment): PaymentResource
    {
        return new PaymentResource($payment->load(['member.user.role', 'event', 'receiver.role']));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment, ActivityLogger $logger): PaymentResource
    {
        $old = $payment->toArray();
        $payment->update([...$request->validated(), 'updated_by' => $request->user()->id]);
        $logger->log('update', 'payment', "Updated payment {$payment->payment_no}.", $payment, $old, $payment->fresh()->toArray());

        return new PaymentResource($payment->fresh()->load(['member.user.role', 'event', 'receiver.role']));
    }

    public function destroy(Payment $payment, ActivityLogger $logger): JsonResponse
    {
        $old = $payment->toArray();
        $logger->log('delete', 'payment', "Deleted payment {$payment->payment_no}.", $payment, $old);
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully.']);
    }

    private function generatePaymentNo(): string
    {
        $prefix = 'PAY-'.now()->format('Ymd');
        $number = Payment::where('payment_no', 'like', "{$prefix}-%")->count() + 1;
        do { $paymentNo = $prefix.'-'.str_pad((string) $number++, 4, '0', STR_PAD_LEFT); }
        while (Payment::where('payment_no', $paymentNo)->exists());
        return $paymentNo;
    }
}
