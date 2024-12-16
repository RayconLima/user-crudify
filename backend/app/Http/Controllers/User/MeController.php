<?php

namespace App\Http\Controllers\User;

use App\Helpers\MinioHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function show()
    {
        $user = User::whereId($this->user->id)->first();
        return UserResource::make($user);
    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo_path' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:4096'],
        ]);

        $user = User::whereId($this->user->id)->first();

        if ($request->hasFile('profile_photo_path')) {
            $file = $request->file('profile_photo_path');
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs('avatars', $fileName, 's3');

            // Gera a URL pública do arquivo armazenado, incluindo a porta 9000
            $user->profile_photo_path = MinioHelper::generateMinioUrl($path);
        }

        $user->save();

        return UserResource::make($user);
    }
}
