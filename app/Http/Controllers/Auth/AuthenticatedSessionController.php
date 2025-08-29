<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * Authenticate the user and return specific user data for cookie-based auth.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {

        // Log the X-XSRF-TOKEN header to the backend terminal
        Log::info('Login Request received.');
        // Validate credentials (from LoginRequest or directly here)
        $validated = Validator::make($request->toArray(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ])->validate();

        // Attempt to authenticate the user
        // Auth::attempt will automatically log the user in and create a session
        if (! Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')], // Laravel's default authentication failed message
            ]);
        }
        // Regenerate the session ID to prevent session fixation attacks
        Session::regenerate();

        // Get the authenticated user
        $user = Auth::user();

        // Return only the desired user attributes for the frontend
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'email_verified_at' => $user->email_verified_at,
            ],
            'message' => 'Login successful.'
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        // For cookie-based authentication, we simply log out the user from the session.
        // Sanctum's session guard will handle clearing the session and invalidating the cookie.
        Auth::guard('web')->logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
