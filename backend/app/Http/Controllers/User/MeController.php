<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class MeController extends Controller
{
    public function __invoke()
    {
        $user = User::whereId(auth()->id())->first();
        return UserResource::make($user);
    }
}
