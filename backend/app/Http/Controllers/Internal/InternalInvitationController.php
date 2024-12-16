<?php

namespace App\Http\Controllers\Internal;

use App\Http\Requests\Invitation\StorePasswordInvitationRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Enums\UserStatus;
use App\Jobs\NewUserRegistered;
use App\Models\User;

class InternalInvitationController extends Controller
{
    public function savePasswordByInvitation(StorePasswordInvitationRequest $request): JsonResponse
    {
        $input = $request->validated();

        try {
            $user = $this->findUserByToken($input['token']);
            $this->updateUser($user, $input);
            NewUserRegistered::dispatch($user);

            return response()->json(['message' => 'Password updated successfully!']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User  not found.'], 404);
        }
    }

    private function findUserByToken(string $token): User
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        return $user;
    }

    private function updateUser (User $user, array $input): void
    {
        $user->update($input);
        $user->status               = UserStatus::Active;
        $user->verification_token   = null;
        $user->email_verified_at    = now();
        $user->save();
    }
}