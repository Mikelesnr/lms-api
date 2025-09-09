<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Http\Request;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust Render's proxy headers for proper HTTPS detection
        $middleware->trustProxies(
            at: ['127.0.0.1', '::1', 'localhost', 'lms-api-i62r.onrender.com'],
            headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR
                | \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST
                | \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT
                | \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO
        );

        // Shared middleware
        $shared = [
            HandleCors::class,
        ];

        // Web middleware stack
        $middleware->web(prepend: $shared);
        $middleware->web(append: [
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
        $exceptions->render(function (Throwable $e) {
            // if (app()->environment('production')) {
            //     return response()->json(['error' => 'Server error'], 500);
            // }

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'exception' => get_class($e),
            ], 500);
        });
    })
    ->create();
