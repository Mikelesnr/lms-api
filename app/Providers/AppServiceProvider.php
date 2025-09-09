<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
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

        // 🛡️ Role-based access gates
        Gate::define('admin-only', fn(User $user) => $user->isAdmin());
        Gate::define('instructor-only', fn(User $user) => $user->isInstructor());
        Gate::define('student-only', fn(User $user) => $user->isStudent());
        Gate::define('create-admin', fn(User $user) => $user->role === 'super_admin');
    }
}
