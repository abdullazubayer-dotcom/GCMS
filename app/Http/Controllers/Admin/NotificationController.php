<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNotificationRequest;
use App\Models\NotificationLog;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = NotificationLog::with('user')
            ->when($request->filled('channel'), fn ($query) => $query->where('channel', $request->string('channel')->toString()))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.notifications.index', [
            'notifications' => $notifications,
            'filters' => $request->only(['channel', 'status']),
        ]);
    }

    public function create(): View
    {
        $users = User::with('role')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.notifications.create', compact('users'));
    }

    public function store(StoreNotificationRequest $request, NotificationService $notificationService): RedirectResponse
    {
        $notification = $notificationService->send($request->validated());

        return redirect()
            ->route('admin.notifications.show', $notification)
            ->with('status', 'Notification attempt saved with status: '.ucfirst($notification->status).'.');
    }

    public function show(NotificationLog $notification): View
    {
        $notification->load('user');

        return view('admin.notifications.show', compact('notification'));
    }
}
