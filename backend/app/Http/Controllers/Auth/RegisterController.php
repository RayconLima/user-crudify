<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use App\Jobs\NewUserRegistered;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(StoreUserRequest $request)
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

            // Gera a URL pública do arquivo armazenado, incluindo a porta 9000
            $user->profile_photo_path = $this->generateMinioUrl($path);
        }

        $user->save();

        NewUserRegistered::dispatch($user);

        return UserResource::make($user);
    }

    private function generateMinioUrl($path)
    {
        // Aqui você deve ajustar a URL base conforme necessário
        $minioUrl = config('filesystems.disks.s3.url');
        return "{$minioUrl}/{$path}";
    }
}