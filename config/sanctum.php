<?php

return [
    'guard' => ['web'], // This is fine for issuing tokens via the web guard

    'expiration' => null, // Tokens never expire unless manually revoked

    'middleware' => [
        'verify_csrf_token' => \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => \Illuminate\Cookie\Middleware\EncryptCookies::class,
    ],
];
