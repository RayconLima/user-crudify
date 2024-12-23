<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Exceptions\InternalServerException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Jobs\NewUserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\UserStatus;
use App\Helpers\MinioHelper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = User::query();
            $query->when($request->has('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            });
            $query->when($request->has('iti'), function ($query) use ($request) {
                $query->where('iti', 'like', '%' . $request->iti . '%');
            });
            $collection = $query->paginate();
            return UserResource::collection($collection);
        } catch (Exception $e) {
            throw new InternalServerException($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $token  = Str::random(60);
            $input  = $request->validated();
            $user   = User::create([
                ...$input,
                'status' => UserStatus::Pending,
                'verification_token' => $token,
                'registration_type' => 'internal',
                'profile_photo_path' => $this->createAvatar(),
            ]);
    
            $user->save();
            NewUserRegistered::dispatch($user);
            return UserResource::make($user);
        } catch (Exception $e) {
            throw new InternalServerException($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $user = User::findOrFail($id);
            return UserResource::make($user);
        } catch (NotFoundException $e) {
            throw new NotFoundException('User not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UpdateUserRequest $request)
    {
        try {
            $user = User::findOrFail($id);
            $input = $request->validated();
            $user->update($input);
            return UserResource::make($user);
        } catch (NotFoundException $e) {
            throw new NotFoundException('User not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->noContent();
        } catch (NotFoundException $e) {
            throw new NotFoundException('User not found');
        }
    }

    protected function createAvatar(): string
    {
        $imageUrl = "https://avatar.iran.liara.run/public";
        $filename = Str::random(10) . '.jpg';

        $path = 'avatars/' . $filename;

        $imageContent = file_get_contents($imageUrl);
        Storage::disk('s3')->put($path, $imageContent);

        return MinioHelper::generateMinioUrl($path);
    }
}
