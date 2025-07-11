<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // Keep this if you have a custom LoginRequest
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Use JsonResponse for API
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * Authenticate the user and issue a Sanctum token.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request): JsonResponse // Changed return type to JsonResponse
    {
        // Validate credentials (from LoginRequest or directly here)
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to authenticate the user
        if (! Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')], // Laravel's default authentication failed message
            ]);
        }

        // Get the authenticated user
        $user = $request->user();

        // Optional: Revoke existing tokens for this user before issuing a new one
        // This is good practice to ensure only one active token per login,
        // enhancing security by making previous tokens unusable.
        $user->tokens()->delete();

        // Create a new Sanctum token for the user
        // You can specify abilities (scopes) if needed, e.g., ['read', 'write']
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the user and the token
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful, token issued.'
        ]);
    }


    /**
     * Destroy an authenticated session.
     */

    /**
     * Destroy an authenticated session and revoke the current token.
     */
    public function destroy(Request $request): JsonResponse // Changed return type to JsonResponse
    {
        // This line gets the currently active token that was used for the request
        // and deletes it, effectively logging out the user from that token.
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully, token revoked.'
        ]);
    }
}
