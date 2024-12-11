<?php

use App\Models\User;

describe('Get me', function () {
    it('should not be possible to access my data', function () {
        $this->getJson(route('auth.me'), [])->assertJson(['message' => 'Unauthenticated.'])->assertStatus(401);
    });
    
    it('should be possible to access my data', function () {
        $user   = User::factory()->create();
        $token  = $user->createToken('auth_token')->plainTextToken;
        $this->getJson(route('auth.me'), [
            'Authorization' => "Bearer {$token}"
        ])
        ->assertJsonStructure([
            'data' => [
                'id',
                'iti',
                'name',
                'email',
            ],
        ])
        ->assertOk();
    });
});

