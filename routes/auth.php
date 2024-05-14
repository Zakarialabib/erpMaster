<?php

declare(strict_types=1);

use Livewire\Volt\Volt;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Admin\Auth\Register as AdminRegister;
use App\Livewire\Admin\Auth\ResetPassword as AdminResetPassword;
use App\Livewire\Admin\Auth\ForgotPassword as AdminForgotPassword;
use App\Livewire\Admin\Auth\ConfirmPassword as AdminConfirmPassword;
use App\Livewire\Auth\SocialAuth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


Route::get('/login/facebook', [SocialAuth::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [SocialAuth::class, 'handleFacebookCallback']);

Route::get('/login/google', [SocialAuth::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [SocialAuth::class, 'handleGoogleCallback']);


Route::middleware('web')->group(function () {
    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Route::get('admin/confirm-password', AdminConfirmPassword::class)
        ->name('admin.password.confirm');
});

Route::post('logout', function (Request $request) {
    if (auth()->check()) {
        auth()->logout();
    } elseif (auth()->guard('customer')->check()) {
        auth()->guard('customer')->logout();
    } elseif (auth()->guard('admin')->check()) {
        auth()->guard('admin')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/home');
})->name('logout');


Route::get('admin/login', AdminLogin::class)
    ->name('admin.login');

Route::get('admin/register', AdminRegister::class)
    ->name('admin.register');

Route::get('admin/forgot-password', AdminForgotPassword::class)
    ->name('admin.password.request');

Route::get('admin/reset-password/{token}', AdminResetPassword::class)
    ->name('admin.password.reset');
