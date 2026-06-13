<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMember
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole('member')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Member access is required.'], 403);
            }

            abort(403, 'Only members can access this page.');
        }

        return $next($request);
    }
}
