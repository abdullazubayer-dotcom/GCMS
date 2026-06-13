<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole(['super_admin', 'admin'])) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Admin access is required.'], 403);
            }

            abort(403, 'Only admins can access this page.');
        }

        return $next($request);
    }
}
