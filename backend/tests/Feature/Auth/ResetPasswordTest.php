<?php

use App\Models\User;

beforeEach(function () {
    $this->user   = User::factory()->create(['email' => 'john@example.com']);
});

describe('reset password', function () {
    it('should reset the password for the user', function () {
        $forgotPassword = $this->postJson(route('auth.forgot-password'), [
            'email' => 'john@example.com',
        ], []);

        $forgotPasswordToken = $forgotPassword->assertStatus(200)->decodeResponseJson()['data']['resetPasswordToken']['token'];

        $data = [
            'token' => $forgotPasswordToken,
            'password' => 'secretPassword1',
            'password_confirmation' => 'secretPassword1',
        ];

        $this->postJson(route('auth.reset-password'), $data, [])
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
                ],
            ]);
    });
});