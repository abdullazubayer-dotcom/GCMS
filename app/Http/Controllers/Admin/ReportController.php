<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports.index');
    }

    public function members(Request $request): View
    {
        $members = Member::with('user')
            ->when($request->filled('status'), fn (Builder $query) => $query->where('membership_status', $request->string('status')->toString()))
            ->when($request->filled('membership_type'), fn (Builder $query) => $query->where('membership_type', $request->string('membership_type')->toString()))
            ->when($request->filled('from_date'), fn (Builder $query) => $query->whereDate('joining_date', '>=', $request->input('from_date')))
            ->when($request->filled('to_date'), fn (Builder $query) => $query->whereDate('joining_date', '<=', $request->input('to_date')))
            ->orderBy('member_code')
            ->get();

        return view('admin.reports.members', [
            'members' => $members,
            'filters' => $request->only(['status', 'membership_type', 'from_date', 'to_date']),
        ]);
    }

    public function payments(Request $request): View
    {
        $payments = $this->paymentQuery($request)
            ->latest('payment_date')
            ->get();

        return view('admin.reports.payments', [
            'payments' => $payments,
            'totalAmount' => $payments->sum('amount'),
            'members' => $this->membersForFilter(),
            'events' => $this->eventsForFilter(),
            'filters' => $request->only(['member_id', 'event_id', 'payment_status', 'payment_method', 'from_date', 'to_date']),
        ]);
    }

    public function duePayments(Request $request): View
    {
        $payments = $this->paymentQuery($request)
            ->whereIn('payment_status', ['due', 'partial'])
            ->latest('payment_date')
            ->get();

        return view('admin.reports.due-payments', [
            'payments' => $payments,
            'totalAmount' => $payments->sum('amount'),
            'members' => $this->membersForFilter(),
            'events' => $this->eventsForFilter(),
            'filters' => $request->only(['member_id', 'event_id', 'payment_method', 'from_date', 'to_date']),
        ]);
    }

    public function events(Request $request): View
    {
        $events = Event::query()
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->string('status')->toString()))
            ->when($request->filled('from_date'), fn (Builder $query) => $query->whereDate('event_date', '>=', $request->input('from_date')))
            ->when($request->filled('to_date'), fn (Builder $query) => $query->whereDate('event_date', '<=', $request->input('to_date')))
            ->orderBy('event_date')
            ->get();

        return view('admin.reports.events', [
            'events' => $events,
            'filters' => $request->only(['status', 'from_date', 'to_date']),
        ]);
    }

    public function dateWiseCollection(Request $request): View
    {
        $collections = Payment::query()
            ->where('payment_status', 'paid')
            ->when($request->filled('from_date'), fn (Builder $query) => $query->whereDate('payment_date', '>=', $request->input('from_date')))
            ->when($request->filled('to_date'), fn (Builder $query) => $query->whereDate('payment_date', '<=', $request->input('to_date')))
            ->select('payment_date', DB::raw('COUNT(*) as total_payments'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('payment_date')
            ->orderBy('payment_date')
            ->get();

        return view('admin.reports.date-wise-collection', [
            'collections' => $collections,
            'totalAmount' => $collections->sum('total_amount'),
            'filters' => $request->only(['from_date', 'to_date']),
        ]);
    }

    public function memberWisePayments(Request $request): View
    {
        $payments = $this->paymentQuery($request)
            ->latest('payment_date')
            ->get()
            ->groupBy('member_id');

        return view('admin.reports.member-wise-payments', [
            'paymentGroups' => $payments,
            'totalAmount' => $payments->flatten(1)->sum('amount'),
            'members' => $this->membersForFilter(),
            'events' => $this->eventsForFilter(),
            'filters' => $request->only(['member_id', 'event_id', 'payment_status', 'from_date', 'to_date']),
        ]);
    }

    private function paymentQuery(Request $request): Builder
    {
        return Payment::with(['member.user', 'event', 'receiver'])
            ->when($request->filled('member_id'), fn (Builder $query) => $query->where('member_id', $request->integer('member_id')))
            ->when($request->filled('event_id'), fn (Builder $query) => $query->where('event_id', $request->integer('event_id')))
            ->when($request->filled('payment_status'), fn (Builder $query) => $query->where('payment_status', $request->string('payment_status')->toString()))
            ->when($request->filled('payment_method'), fn (Builder $query) => $query->where('payment_method', $request->string('payment_method')->toString()))
            ->when($request->filled('from_date'), fn (Builder $query) => $query->whereDate('payment_date', '>=', $request->input('from_date')))
            ->when($request->filled('to_date'), fn (Builder $query) => $query->whereDate('payment_date', '<=', $request->input('to_date')));
    }

    private function membersForFilter()
    {
        return Member::with('user')->orderBy('member_code')->get();
    }

    private function eventsForFilter()
    {
        return Event::orderByDesc('event_date')->get();
    }
}
