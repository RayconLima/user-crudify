<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->user   = User::factory()->create();
    $this->token  = $this->user->createToken('auth_token')->plainTextToken;
});

describe('validations', function () {
    it('should validate the data to create a new user and return 422 for missing fields', function () {
        $this->postJson(route('users.store'), [], [
            'Authorization' => "Bearer {$this->token}"
        ])->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => trans('validation.required', ['attribute' => 'name']),
                'email' => trans('validation.required', ['attribute' => 'email']),
                'password' => trans('validation.required', ['attribute' => 'password']),
            ]);
    });
    it('should validate data to return 422 when updating a user', function () {
        $this->putJson(route('users.update', ['user' => $this->user->id]), [], [
            'Authorization' => "Bearer {$this->token}"
        ])->assertStatus(422)->assertJsonValidationErrors([
            'name' => trans('validation.required', ['attribute' => 'name']),
        ]);
    });
    it('should validate the data to return 422 when updating a user whose password is at least 6 characters long', function () {
        $data = [
            'name'      => 'John Smith',
            'password'  => Str::random(5),
        ];

        $response = $this->putJson(route('users.update', ['user' => $this->user->id]), $data, [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'password' => trans(
                    'validation.min.string', [ 'attribute' => 'password', 'min'       => 6]
                ),
            ]);
    });
});