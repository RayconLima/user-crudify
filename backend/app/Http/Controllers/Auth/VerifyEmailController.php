<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Exceptions\EmailAlreadyVerifiedException;
use App\Exceptions\TokenInvalidException;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);
        $user = User::query()->where('verification_token', $request->token)->first();

        if(!$user) {
            throw new TokenInvalidException();
        }

        if($user->email_verified_at) 
        {
            throw new EmailAlreadyVerifiedException();
        }
        $user->status = UserStatus::Active;
        $user->verification_token   = null;
        $user->email_verified_at    = now();
        $user->save();

        return UserResource::make($user);
    }
}
