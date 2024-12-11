<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

describe('Authentication', function () {
    it('Should be able to authenticate - 200', function () {
        $user = User::factory()->create([
            'email'     => 'valid@example.com',
            'password'  => Hash::make('password'),
        ]);

        $data = [
            'email'     => $user->email,
            'password'  => 'password',
        ];
        
        $this->postJson(route('auth.login'), $data)->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                ],
                'token' => 'token',
            ]);
    });

    it("Shouldn't be able to authenticate because of invalid credentials - 401", function () {
        $user = User::factory()->create();
        $dataWithInvalidPassword = [
            'email'     => $user->email,
            'password'  => 'wrong-password',
        ];
        $responseWithInvalidPassword = $this->postJson(route('auth.login'), $dataWithInvalidPassword);
        $responseWithInvalidPassword->assertStatus(401);

        $dataWithInvalidEmail = [
            'email'     => 'faker@email.com',
            'password'  => 'password',
        ];
        $responseWithInvalidEmail = $this->postJson(route('auth.login'), $dataWithInvalidEmail);
        $responseWithInvalidEmail->assertStatus(401);
    });

    it('Should return 422 when there are invalid entries', function () {
        $response = $this->postJson(route('auth.login'), ['email' => '', 'password' => '']);
        $response->assertStatus(422);
    });
});

describe('Validations', function () {
    it(('should require email'), function () {
        $this->postJson(route('auth.login', [
            'password' => 'password'
        ]))->assertJsonValidationErrors([
            'email' => trans('validation.required', ['attribute' => 'email']),
        ]);
    });
    it(('should require password'), function () {
        $user = User::factory()->create();
        $this->postJson(route('auth.login', [
            'email' => $user->email
        ]))->assertJsonValidationErrors([
            'password' => trans('validation.required', ['attribute' => 'password']),
        ]);
    });
});