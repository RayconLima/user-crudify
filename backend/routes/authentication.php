<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Internal\InternalInvitationController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)->name('auth.login');
Route::post('register', RegisterController::class)->name('auth.register');
Route::post('invitation/savePassword', [InternalInvitationController::class, 'savePasswordByInvitation'])->name('auth.invitation');
Route::post('verify-email', VerifyEmailController::class);
Route::post('forgot-password', ForgotPasswordController::class);
Route::post('reset-password', ResetPasswordController::class);