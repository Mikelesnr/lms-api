<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified via a signed URL.
     */
    public function __invoke(Request $request)
    {
        $userId = $request->route('id');
        $hash = $request->route('hash');

        $user = User::findOrFail($userId);

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403, 'Invalid email hash.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return redirect(config('app.frontend_url') . '/dashboard/' . $user->role->value);;
    }
}
