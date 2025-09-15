<?php

use App\Http\Controllers\Auth\VerifyEmailController;
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

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    // Removed verify-email route - verification only happens during registration
    
    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
    
    // Profile route
    Route::get('profile', [App\Http\Controllers\Frontend\ProfileController::class, 'show'])
        ->name('profile.show');
    
    // Add logout route
    Route::post('logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
