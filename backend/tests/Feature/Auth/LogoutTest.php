<?php

use App\Models\User;

describe('Logout', function () {
    it('Should logout case are authenticated', function () {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->postJson(route('auth.logout'), [], [
            'Authorization' => "Bearer {$token}"
        ])->assertStatus(204);
    });
    
    it("user unauthenticated shouldn't logout", function () {
        $this->postJson(route('auth.logout'), [], [])->assertJson(['message' => 'Unauthenticated.'])->assertStatus(401);
    });
});