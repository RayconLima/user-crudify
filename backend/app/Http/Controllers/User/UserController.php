<?php

namespace App\Http\Controllers\User;

use App\Exceptions\InternalServerException;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

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
            $input  = $request->validated();
            $user   = User::create($input);
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
        } catch (Exception $e) {
            throw new InternalServerException($e->getMessage());
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
        } catch (Exception $e) {
            throw new InternalServerException($e->getMessage());
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
        } catch (Exception $e) {
            throw new InternalServerException($e->getMessage());
        }
    }
}
