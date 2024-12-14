<?php

use App\Http\Controllers\Internal\InternalInvitationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\MeController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)->name('auth.login');
Route::post('register', RegisterController::class)->name('auth.register');
Route::post('invitation/savePassword', [InternalInvitationController::class, 'savePasswordByInvitation'])->name('auth.invitation');
Route::post('verify-email', VerifyEmailController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [MeController::class, 'show'])->name('auth.me');
    Route::post('/me/upload-avatar', [MeController::class, 'updateProfilePhoto'])->name('auth.me.upload-avatar');
    Route::post('/me/password', PasswordController::class)->name('auth.password');
    Route::post('/logout', LogoutController::class)->name('auth.logout');
    Route::apiResource('users', UserController::class);
});