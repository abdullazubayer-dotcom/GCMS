<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::with('role')->where('login_id', $data['login_id'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'The login ID or password is incorrect.'], 422);
        }

        if ($user->status !== 'active') {
            return response()->json(['message' => 'This account is not active.'], 403);
        }

        if (! $user->hasRole(['super_admin', 'admin', 'member'])) {
            return response()->json(['message' => 'This account does not have a valid role.'], 403);
        }

        $abilities = $user->hasRole(['super_admin', 'admin']) ? ['admin'] : ['member'];
        $token = $user->createToken($data['device_name'], $abilities)->plainTextToken;

        $user->forceFill(['last_login_at' => now()])->save();

        return response()->json([
            'message' => 'Login successful.',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'must_change_password' => (bool) $user->must_change_password,
            'user' => new UserResource($user),
        ]);
    }

    public function me(Request $request): UserResource
    {
        return new UserResource($request->user()->load('role'));
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'All API sessions have been logged out.']);
    }

    public function changePassword(ChangePasswordRequest $request, ActivityLogger $activityLogger): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();

        if (! Hash::check($data['current_password'], $user->password)) {
            return response()->json(['message' => 'The current password is incorrect.'], 422);
        }

        $user->forceFill([
            'password' => $data['password'],
            'must_change_password' => false,
        ])->save();

        $activityLogger->log('password_reset', 'auth', "Password changed for {$user->login_id}.", $user);

        return response()->json([
            'message' => 'Password changed successfully.',
            'user' => new UserResource($user->load('role')),
        ]);
    }
}
