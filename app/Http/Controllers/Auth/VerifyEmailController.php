<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\User;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    // public function __invoke(Request $request, $id, $hash): RedirectResponse
    // {
    //     $user = User::findOrFail($id);

    //     if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
    //         throw new AuthorizationException();
    //     }

    //     if (! $user->hasVerifiedEmail()) {
    //         $user->markEmailAsVerified();
    //         event(new Verified($user));
    //     }

    //     return redirect()->to(config('app.frontend_url') . '/auth/login?verified=1');
    // }

    public function __invoke(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Check email hash
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->view('errors.email_verification', [
                'reason' => 'Email hash mismatch',
                'user_id' => $id,
                'expected_hash' => sha1($user->getEmailForVerification()),
                'provided_hash' => $hash,
                'url' => $request->fullUrl(),
            ], 403);
        }

        // Mark as verified if not already
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));

            return view('errors.email_verification', [
                'reason' => 'Email verified successfully',
                'user_id' => $id,
                'url' => $request->fullUrl(),
            ]);
        }

        // Already verified
        return view('errors.email_verification', [
            'reason' => 'Email already verified',
            'user_id' => $id,
            'url' => $request->fullUrl(),
        ]);
    }
}
