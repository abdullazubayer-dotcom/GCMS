<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PasswordChangeController extends Controller
{
    public function edit(): View
    {
        return view('auth.change-password');
    }

    public function update(ChangePasswordRequest $request, ActivityLogger $activityLogger): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $data = $request->validated();

        if (! Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->forceFill([
            'password' => $data['password'],
            'must_change_password' => false,
        ])->save();

        $activityLogger->log(
            'password_reset',
            'auth',
            "Password changed for login ID {$user->login_id}.",
            $user
        );

        if ($user->hasRole(['super_admin', 'admin'])) {
            return redirect()->route('admin.dashboard')->with('status', 'Password changed successfully.');
        }

        return redirect()->route('member.dashboard')->with('status', 'Password changed successfully.');
    }
}
