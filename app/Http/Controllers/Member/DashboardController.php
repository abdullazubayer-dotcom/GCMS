<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\NotificationLog;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $memberId = $user->member?->id;

        $upcomingEventsCount = Event::where('status', 'published')
            ->where('event_date', '>=', today())
            ->count();

        $paymentsCount = Payment::where('member_id', $memberId)->count();
        $notificationsCount = NotificationLog::where('user_id', $user->id)->count();
        $recentPayments = Payment::where('member_id', $memberId)
            ->latest()
            ->take(5)
            ->get();

        return view('member.dashboard', compact(
            'user',
            'upcomingEventsCount',
            'paymentsCount',
            'notificationsCount',
            'recentPayments'
        ));
    }

    public function profile(): View
    {
        $user = Auth::user()->load('member');

        return view('member.profile', compact('user'));
    }

    public function events(): View
    {
        $events = Event::where('status', 'published')
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->paginate(10);

        return view('member.events', compact('events'));
    }

    public function payments(): View
    {
        $memberId = Auth::user()->member?->id;

        $payments = Payment::with('event')
            ->where('member_id', $memberId)
            ->latest()
            ->paginate(10);

        return view('member.payments', compact('payments'));
    }

    public function notifications(): View
    {
        $notifications = NotificationLog::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('member.notifications', compact('notifications'));
    }
}
