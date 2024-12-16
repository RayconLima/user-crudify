<?php

use App\Models\User;

beforeEach(function () {
    $this->user   = User::factory()->create(['email' => 'john@example.com']);
});


describe('forgot password', function () {
    it('should send a reset password token to the user', function () {
        $data = [
            'email' => 'john@example.com',
        ];

        $this->postJson(route('auth.forgot-password'), $data, [])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'iti',
                    'name',
                    'email',
                    'status',
                    'verification_token',
                    'registration_type',
                    'profile_photo_path',
                    'resetPasswordToken' => [
                        'token',
                    ]
                ],
            ]);
    });
});