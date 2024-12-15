<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\MeController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/authentication.php';

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [MeController::class, 'show'])->name('auth.me');
    Route::post('/me/upload-avatar', [MeController::class, 'updateProfilePhoto'])->name('auth.me.upload-avatar');
    Route::post('/me/password', PasswordController::class)->name('auth.password');
    Route::post('/logout', LogoutController::class)->name('auth.logout');
    Route::apiResource('users', UserController::class);
});