<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Shared middleware
        $shared = [
            HandleCors::class,
        ];

        // Web middleware stack
        $middleware->web(prepend: $shared);
        $middleware->web(append: [
            Illuminate\Session\Middleware\StartSession::class,
            Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            SubstituteBindings::class,
        ]);

        // API middleware stack (stateless Sanctum token auth)
        $middleware->api(prepend: $shared);
        $middleware->api(append: [
            SubstituteBindings::class,
        ]);

        // Aliases
        $middleware->alias([
            'verified' => EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Customize exception rendering if needed
        // $exceptions->render(fn(Throwable $e, Request $request) => ...);
    })
    ->create();
