<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Jobs\ForgotPasswordRequested;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request)
    {
        $input  = $request->validated();
        $user   = User::query()->whereEmail($input['email'])->first();
        
        if(!$user) {
            throw new NotFoundException('User not found');
        }

        $data = $user->resetPasswordTokens()->create([
            'token' => strtoupper(Str::random(6))
        ]);

        ForgotPasswordRequested::dispatch($user, $data->token);
        return UserResource::make($user);
    }
}
