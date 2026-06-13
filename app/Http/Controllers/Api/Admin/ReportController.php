<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\PaymentResource;
use App\Models\Event;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function members(Request $request)
    {
        $rows = Member::with('user.role')
            ->when($request->filled('status'), fn ($q) => $q->where('membership_status', $request->string('status')))
            ->when($request->filled('membership_type'), fn ($q) => $q->where('membership_type', $request->string('membership_type')))
            ->when($request->filled('from_date'), fn ($q) => $q->whereDate('joining_date', '>=', $request->input('from_date')))
            ->when($request->filled('to_date'), fn ($q) => $q->whereDate('joining_date', '<=', $request->input('to_date')))
            ->orderBy('member_code')->paginate(min($request->integer('per_page', 50), 100));
        return MemberResource::collection($rows);
    }

    public function payments(Request $request)
    {
        return PaymentResource::collection($this->paymentQuery($request)->latest('payment_date')->paginate(min($request->integer('per_page', 50), 100)));
    }

    public function duePayments(Request $request)
    {
        return PaymentResource::collection($this->paymentQuery($request)->whereIn('payment_status', ['due', 'partial'])->latest('payment_date')->paginate(min($request->integer('per_page', 50), 100)));
    }

    public function events(Request $request)
    {
        $rows = Event::query()->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('from_date'), fn ($q) => $q->whereDate('event_date', '>=', $request->input('from_date')))
            ->when($request->filled('to_date'), fn ($q) => $q->whereDate('event_date', '<=', $request->input('to_date')))
            ->orderBy('event_date')->paginate(min($request->integer('per_page', 50), 100));
        return EventResource::collection($rows);
    }

    public function dateWiseCollection(Request $request): JsonResponse
    {
        $rows = Payment::where('payment_status', 'paid')
            ->when($request->filled('from_date'), fn ($q) => $q->whereDate('payment_date', '>=', $request->input('from_date')))
            ->when($request->filled('to_date'), fn ($q) => $q->whereDate('payment_date', '<=', $request->input('to_date')))
            ->select('payment_date', DB::raw('COUNT(*) as total_payments'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('payment_date')->orderBy('payment_date')->get();
        return response()->json(['data' => $rows, 'summary' => ['total_amount' => $rows->sum('total_amount')]]);
    }

    public function memberWisePayments(Request $request): JsonResponse
    {
        $rows = $this->paymentQuery($request)->latest('payment_date')->get()->groupBy('member_id')
            ->map(fn ($payments) => ['member' => new MemberResource($payments->first()->member), 'total_amount' => $payments->sum('amount'), 'payments' => PaymentResource::collection($payments)])->values();
        return response()->json(['data' => $rows, 'summary' => ['total_amount' => $rows->sum('total_amount')]]);
    }

    private function paymentQuery(Request $request): Builder
    {
        return Payment::with(['member.user.role', 'event', 'receiver.role'])
            ->when($request->filled('member_id'), fn ($q) => $q->where('member_id', $request->integer('member_id')))
            ->when($request->filled('event_id'), fn ($q) => $q->where('event_id', $request->integer('event_id')))
            ->when($request->filled('payment_status'), fn ($q) => $q->where('payment_status', $request->string('payment_status')))
            ->when($request->filled('payment_method'), fn ($q) => $q->where('payment_method', $request->string('payment_method')))
            ->when($request->filled('from_date'), fn ($q) => $q->whereDate('payment_date', '>=', $request->input('from_date')))
            ->when($request->filled('to_date'), fn ($q) => $q->whereDate('payment_date', '<=', $request->input('to_date')));
    }
}
