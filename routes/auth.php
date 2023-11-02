<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Auth\Login as ClientLogin;
use App\Livewire\Auth\Register as ClientRegister;
use App\Livewire\Auth\ConfirmPassword as ClientConfirmPassword;
use App\Livewire\Auth\ForgotPassword as ClientForgotPassword;
use App\Livewire\Auth\ResetPassword as ClientResetPassword;
use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Admin\Auth\Register as AdminRegister;
use App\Livewire\Admin\Auth\ResetPassword as AdminResetPassword;
use App\Livewire\Admin\Auth\ForgotPassword as AdminForgotPassword;
use App\Livewire\Admin\Auth\ConfirmPassword as AdminConfirmPassword;
use App\Livewire\Auth\SocialAuth;
use Illuminate\Support\Facades\Route;

Route::get('login', ClientLogin::class)
    ->name('auth.login');

Route::get('register', ClientRegister::class)
    ->name('auth.register');

Route::get('forgot-password', ClientForgotPassword::class)
    ->name('password.request');

Route::get('reset-password/{token}', ClientResetPassword::class)
    ->name('password.reset');

Route::get('admin/login', AdminLogin::class)
    ->name('admin.login');

Route::get('admin/register', AdminRegister::class)
    ->name('admin.register');

Route::get('admin/forgot-password', AdminForgotPassword::class)
    ->name('admin.password.request');

Route::get('admin/reset-password/{token}', AdminResetPassword::class)
    ->name('admin.password.reset');

Route::get('/login/facebook', [SocialAuth::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [SocialAuth::class, 'handleFacebookCallback']);

Route::get('/login/google', [SocialAuth::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [SocialAuth::class, 'handleGoogleCallback']);

Route::middleware('guest:customer')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', ClientConfirmPassword::class)
        ->name('password.confirm');

    Route::get('admin/confirm-password', AdminConfirmPassword::class)
        ->name('admin.password.confirm');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
