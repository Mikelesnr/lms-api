<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;

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
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        if (app()->environment('production')) {
            URL::forceScheme('https');
        };
        // Customizing the email verification notification
        VerifyEmail::createUrlUsing(function ($notifiable) {
            // Protect against unexpected nulls — only run during email generation
            if (! $notifiable) {
                \Log::warning('VerifyEmail::createUrlUsing received null $notifiable.');
                return URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), []);
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
    }
}
