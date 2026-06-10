<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/password/change', [PasswordChangeController::class, 'edit'])->name('password.change');
    Route::post('/password/change', [PasswordChangeController::class, 'update'])->name('password.change.update');

    Route::middleware('password.changed')->group(function () {
        Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('/members', [AdminMemberController::class, 'index'])->name('members.index');
            Route::get('/members/create', [AdminMemberController::class, 'create'])->name('members.create');
            Route::post('/members', [AdminMemberController::class, 'store'])->name('members.store');
            Route::get('/members/{member}', [AdminMemberController::class, 'show'])->name('members.show');
            Route::get('/members/{member}/edit', [AdminMemberController::class, 'edit'])->name('members.edit');
            Route::put('/members/{member}', [AdminMemberController::class, 'update'])->name('members.update');
            Route::resource('events', AdminEventController::class);
            Route::resource('payments', AdminPaymentController::class);
            Route::resource('notifications', AdminNotificationController::class)
                ->only(['index', 'create', 'store', 'show']);
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/', [AdminReportController::class, 'index'])->name('index');
                Route::get('/members', [AdminReportController::class, 'members'])->name('members');
                Route::get('/payments', [AdminReportController::class, 'payments'])->name('payments');
                Route::get('/due-payments', [AdminReportController::class, 'duePayments'])->name('due-payments');
                Route::get('/events', [AdminReportController::class, 'events'])->name('events');
                Route::get('/date-wise-collection', [AdminReportController::class, 'dateWiseCollection'])->name('date-wise-collection');
                Route::get('/member-wise-payments', [AdminReportController::class, 'memberWisePayments'])->name('member-wise-payments');
            });
        });

        Route::middleware('member')->prefix('member')->name('member.')->group(function () {
            Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
            Route::get('/profile', [MemberDashboardController::class, 'profile'])->name('profile');
            Route::get('/events', [MemberDashboardController::class, 'events'])->name('events');
            Route::get('/payments', [MemberDashboardController::class, 'payments'])->name('payments');
            Route::get('/notifications', [MemberDashboardController::class, 'notifications'])->name('notifications');
        });
    });
});
