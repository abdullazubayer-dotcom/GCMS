<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $user = User::with('role')->where('login_id', $credentials['login_id'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['login_id' => 'The login ID or password is incorrect.'])
                ->onlyInput('login_id');
        }

        if (! $user->hasRole(['super_admin', 'admin', 'member'])) {
            return back()
                ->withErrors(['login_id' => 'This account does not have a valid role.'])
                ->onlyInput('login_id');
        }

        if ($user->status !== 'active') {
            return back()
                ->withErrors(['login_id' => 'This account is not active. Please contact club authority.'])
                ->onlyInput('login_id');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $user->forceFill([
            'last_login_at' => now(),
        ])->save();

        if ($user->must_change_password) {
            return redirect()->route('password.change');
        }

        return redirect()->intended($this->redirectPath($user));
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('status', 'You have been logged out.');
    }

    private function redirectPath(User $user): string
    {
        if ($user->hasRole(['super_admin', 'admin'])) {
            return '/admin/dashboard';
        }

        return '/member/dashboard';
    }
}
