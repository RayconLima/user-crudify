<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\MeController;
use App\Http\Controllers\User\UserController;

Route::post('login', LoginController::class)->name('auth.login');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', LogoutController::class)->name('auth.logout');
    Route::get('/me', MeController::class)->name('auth.me');
    Route::apiResource('users', UserController::class);
});