<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

// GET: Display admin registration form
Route::get('/internal/register-admin', function () {
    return view('admin.register');
})->name('admin.register.form');

Route::post('/internal/register-admin', [RegisteredUserController::class, 'storeAdmin'])
    ->name('admin.register.submit');

// Route::prefix('auth')->group(base_path('routes/auth.php'));
