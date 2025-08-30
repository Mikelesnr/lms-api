<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Routing\Middleware\SubstituteBindings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Apply shared middleware to both web and api groups
        $shared = [
            StartSession::class,
            HandleCors::class,
            EnsureFrontendRequestsAreStateful::class,
        ];

        $middleware->web(prepend: $shared);
        $middleware->api(prepend: $shared);

        $middleware->web(append: [
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ]);

        $middleware->api(append: [
            SubstituteBindings::class,
        ]);

        $middleware->alias([
            'verified' => EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // You can customize exception rendering here if needed
        // $exceptions->render(fn(Throwable $e, Request $request) => ...);
    })
    ->create();
