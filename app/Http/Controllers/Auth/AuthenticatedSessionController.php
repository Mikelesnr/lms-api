<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('frontend')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'email_verified_at' => $user->email_verified_at,
            ],
            'token' => $token,
            'message' => 'Login successful.'
        ]);
    }

    /**
     * Revoke the current access token (logout).
     */
    public function destroy(): JsonResponse
    {
        Auth::user()->tokens()->where('id', Auth::user()->currentAccessToken()->id)->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
