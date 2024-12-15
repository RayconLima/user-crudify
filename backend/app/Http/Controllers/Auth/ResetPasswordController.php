<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ResetPasswordTokenInvalidException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\UserPasswordResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request)
    {
        $input = $request->validated();
        $token = UserPasswordResetToken::query()
            ->with('user')
            ->whereDate('created_at', '>=', now()->subHours(24)->toDateString())
            ->whereToken($input['token'])
            ->first();
        
        if(!$token) {
            throw new ResetPasswordTokenInvalidException();
        }

        $user = $token->user;
        $user->password = Hash::make($input['password']);
        $user->save();

        $user->resetPasswordTokens()->delete();
        return UserResource::make($user);
    }
}
