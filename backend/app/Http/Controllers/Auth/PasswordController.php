<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6', Password::min(6)->letters()->numbers(), 'confirmed'],
        ]);
        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);
        $user = auth()->user();
        $user->password = $request->password;
        $user->save();
        
        return UserResource::make($user);
    }
}
