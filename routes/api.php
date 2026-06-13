<?php

use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\EventController as AdminEventController;
use App\Http\Controllers\Api\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Api\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Api\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberPortalController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('auth/login', [AuthController::class, 'login'])->middleware('throttle:6,1');

    Route::middleware(['auth:sanctum', 'active'])->group(function (): void {
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::post('auth/logout-all', [AuthController::class, 'logoutAll']);
        Route::put('auth/password', [AuthController::class, 'changePassword'])->middleware('throttle:6,1');

        Route::prefix('member')->middleware('member')->group(function (): void {
            Route::middleware('password.changed')->group(function (): void {
                Route::get('profile', [MemberPortalController::class, 'profile']);
                Route::get('events', [MemberPortalController::class, 'events']);
                Route::get('payments', [MemberPortalController::class, 'payments']);
                Route::get('notifications', [MemberPortalController::class, 'notifications']);
            });
        });

        Route::prefix('admin')->middleware(['admin', 'password.changed'])->group(function (): void {
            Route::get('dashboard', DashboardController::class);
            Route::apiResource('members', AdminMemberController::class);
            Route::apiResource('events', AdminEventController::class);
            Route::apiResource('payments', AdminPaymentController::class);
            Route::apiResource('notifications', AdminNotificationController::class)->only(['index', 'store', 'show']);
            Route::prefix('reports')->group(function (): void {
                Route::get('members', [ReportController::class, 'members']);
                Route::get('payments', [ReportController::class, 'payments']);
                Route::get('due-payments', [ReportController::class, 'duePayments']);
                Route::get('events', [ReportController::class, 'events']);
                Route::get('date-wise-collection', [ReportController::class, 'dateWiseCollection']);
                Route::get('member-wise-payments', [ReportController::class, 'memberWisePayments']);
            });
        });
    });
});
