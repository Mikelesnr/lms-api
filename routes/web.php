<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});


Route::prefix('auth')->group(base_path('routes/auth.php'));
