<?php

use App\Http\Controllers\Internal\InternalInvitationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\MeController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)->name('auth.login');
Route::post('register', [RegisterController::class, 'register'])->name('auth.register');
Route::post('invitation/savePassword', [InternalInvitationController::class, 'savePasswordByInvitation'])->name('auth.invitation');

// TODO: remove or use this route
// Route::get('verify/{token}', [RegisterController::class, 'verify'])->name('verify');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', LogoutController::class)->name('auth.logout');
    Route::get('/me', MeController::class)->name('auth.me');
    Route::apiResource('users', UserController::class);
});