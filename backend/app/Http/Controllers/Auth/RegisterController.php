<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Support\Str;
use App\Jobs\newUserRegistered;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function __invoke(StoreUserRequest $request)
    {
        $token  = Str::random(60);
        $input  = $request->validated();
        $user   = User::create([
            ...$input,
            'registration_type' => 'self',
            'verification_token' => $token,
            'status' => UserStatus::Pending,
        ]);
        newUserRegistered::dispatch($user);
        return response()->json(['message' => 'Usuário cadastrado com sucesso!']);
    }
}
