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

        $expectedHash = sha1($user->getEmailForVerification());

        return view('errors.email_verification', [
            'reason' => 'Diagnostic view — no verification performed',
            'user_id' => $id,
            'expected_hash' => $expectedHash,
            'provided_hash' => $hash,
            'url' => $request->fullUrl(),
        ]);
    }
}
