<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMembers = Member::count();
        $activeMembers = Member::where('membership_status', 'active')->count();
        $inactiveMembers = Member::where('membership_status', 'inactive')->count();
        $totalEvents = Event::count();
        $upcomingEvents = Event::where('status', 'published')
            ->where('event_date', '>=', today())
            ->count();
        $totalPaymentCollection = Payment::where('payment_status', 'paid')->sum('amount');
        $duePayments = Payment::whereIn('payment_status', ['due', 'partial'])->sum('amount');
        $recentMembers = Member::with('user')
            ->latest()
            ->take(5)
            ->get();
        $recentPayments = Payment::with('member.user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMembers',
            'activeMembers',
            'inactiveMembers',
            'totalEvents',
            'upcomingEvents',
            'totalPaymentCollection',
            'duePayments',
            'recentMembers',
            'recentPayments'
        ));
    }
}
