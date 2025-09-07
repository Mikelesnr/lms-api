<?php

return [

    'paths' => ['sanctum/csrf-cookie', 'api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_filter([
        env('APP_FRONTEND_URL'),
        'https://lms-frontend-6qso.onrender.com',
        'https://lms-manage.netlify.app',
        'http://localhost:3000',
        'http://127.0.0.1:3000',
    ]),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
