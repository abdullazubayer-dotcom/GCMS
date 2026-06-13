<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\NotificationLogResource;
use App\Http\Resources\PaymentResource;
use App\Models\Event;
use App\Models\NotificationLog;
use App\Models\Payment;
use Illuminate\Http\Request;

class MemberPortalController extends Controller
{
    public function profile(Request $request): MemberResource
    {
        return new MemberResource($request->user()->member()->with('user.role')->firstOrFail());
    }

    public function events(Request $request)
    {
        $events = Event::where('status', 'published')
            ->when($request->filled('from_date'), fn ($query) => $query->whereDate('event_date', '>=', $request->input('from_date')))
            ->orderBy('event_date')
            ->paginate($request->integer('per_page', 15));

        return EventResource::collection($events);
    }

    public function payments(Request $request)
    {
        $memberId = $request->user()->member?->id;
        $payments = Payment::with(['member.user.role', 'event', 'receiver.role'])
            ->where('member_id', $memberId)
            ->latest('payment_date')
            ->paginate($request->integer('per_page', 15));

        return PaymentResource::collection($payments);
    }

    public function notifications(Request $request)
    {
        $notifications = NotificationLog::with('user.role')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return NotificationLogResource::collection($notifications);
    }
}
