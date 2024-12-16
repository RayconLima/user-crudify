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

    it('should be change my password', function () {
        $user   = User::factory()->create();
        $token  = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'password' => 'secretPassword1',
            'password_confirmation' => 'secretPassword1',
        ];
        
        $this->postJson(route('auth.password'), $data, [
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