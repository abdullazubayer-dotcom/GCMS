<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNotificationRequest;
use App\Http\Resources\NotificationLogResource;
use App\Models\NotificationLog;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $logs = NotificationLog::with('user.role')
            ->when($request->filled('channel'), fn ($query) => $query->where('channel', $request->string('channel')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()->paginate(min($request->integer('per_page', 15), 100))->withQueryString();
        return NotificationLogResource::collection($logs);
    }

    public function store(StoreNotificationRequest $request, NotificationService $service): JsonResponse
    {
        $log = $service->send($request->validated())->load('user.role');
        return (new NotificationLogResource($log))->response()->setStatusCode(201);
    }

    public function show(NotificationLog $notification): NotificationLogResource
    {
        return new NotificationLogResource($notification->load('user.role'));
    }
}
