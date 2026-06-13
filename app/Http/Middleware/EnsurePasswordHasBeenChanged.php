<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordHasBeenChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->must_change_password) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You must change your temporary password before continuing.',
                    'must_change_password' => true,
                ], 403);
            }

            return redirect()->route('password.change');
        }

        return $next($request);
    }
}
