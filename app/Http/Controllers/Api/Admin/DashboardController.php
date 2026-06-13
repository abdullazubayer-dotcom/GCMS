<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Http\Resources\PaymentResource;
use App\Models\Event;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => [
                'total_members' => Member::count(),
                'active_members' => Member::where('membership_status', 'active')->count(),
                'inactive_members' => Member::where('membership_status', 'inactive')->count(),
                'total_events' => Event::count(),
                'upcoming_events' => Event::where('status', 'published')->whereDate('event_date', '>=', today())->count(),
                'total_payment_collection' => Payment::where('payment_status', 'paid')->sum('amount'),
                'due_payments' => Payment::whereIn('payment_status', ['due', 'partial'])->sum('amount'),
                'recent_members' => MemberResource::collection(Member::with('user.role')->latest()->limit(5)->get()),
                'recent_payments' => PaymentResource::collection(Payment::with(['member.user.role', 'event', 'receiver.role'])->latest()->limit(5)->get()),
            ],
        ]);
    }
}
