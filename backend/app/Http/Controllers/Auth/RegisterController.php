<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Helpers\MinioHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpFormRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use App\Jobs\NewUserRegistered;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(SignUpFormRequest $request)
    {
        $input = $request->validated();
        $user = User::create([
            ...$input,
            'status' => UserStatus::Pending,
            'registration_type' => 'self',
            'verification_token' => Str::random(60),
        ]);

        if ($request->hasFile('profile_photo_path')) {
            $file = $request->file('profile_photo_path');
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs('avatars', $fileName, 's3');
            $user->profile_photo_path = MinioHelper::generateMinioUrl($path);;
        }

        $user->save();

        NewUserRegistered::dispatch($user);

        return UserResource::make($user);
    }
}