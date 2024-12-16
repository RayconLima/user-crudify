<?php

use App\Enums\UserStatus;

beforeEach(function () {
    $this->customNumber = mt_rand(10000000000, 99999999999);
});

describe('register', function () {
    it('should create a new user with valid data', function () {
        $data = [
            'name'      => 'John Snow',
            'iti'       => $this->customNumber,
            'email'     => 'john@example.com',
            'password'  => 'secretPassword1',
            'password_confirmation'  => 'secretPassword1',
        ];


        $response = $this->post(route('auth.register'), $data, [])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'iti',
                    'name',
                    'email',
                    'status',
                    'verification_token',
                    'registration_type',
                    'profile_photo_path'
                ],
            ]);
            
        $this->assertDatabaseHas('users', [
            'id' => $response['data']['id'],
            'name' => 'John Snow',
            'email' => 'john@example.com',
            'iti' => $data['iti'],
            'status' => UserStatus::Pending,
            'verification_token' => $response['data']['verification_token'],
            'registration_type' => 'self',
        ]);

    });
});