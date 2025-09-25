<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('register', 'pages.auth.register')
        ->name('register');

    // Add POST route for registration form submission
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'store'])
        ->name('register.store');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');

    // Traditional form-based reset password routes
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'show'])
        ->name('password.reset.form');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('reset.password.post');
});

Route::middleware('auth')->group(function () {
    // Removed verify-email route - verification only happens during registration

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');



    // Add logout route
    Route::post('logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
