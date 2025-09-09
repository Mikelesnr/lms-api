<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        // Force HTTPS in production
        if (app()->environment('production')) {
            $url->forceScheme('https');
        }

        // 🔐 Customize password reset URL for frontend SPA
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            $email = $notifiable->getEmailForPasswordReset();
            return config('app.frontend_url') . "/auth/password-reset/{$token}?email={$email}";
        });

        // ✉️ Customize email verification URL for frontend SPA
        VerifyEmail::createUrlUsing(function ($notifiable) {
            if (! $notifiable || ! method_exists($notifiable, 'getEmailForVerification')) {
                Log::warning('Verification email generation failed — missing or invalid notifiable.');
                return config('app.frontend_url') . '/auth/login?error=missing-user';
            }

            return URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        });


        // 🛡️ Role-based access gates
        Gate::define('admin-only', fn(User $user) => $user->isAdmin());
        Gate::define('instructor-only', fn(User $user) => $user->isInstructor());
        Gate::define('student-only', fn(User $user) => $user->isStudent());
        Gate::define('create-admin', fn(User $user) => $user->role === 'super_admin');
    }
}
