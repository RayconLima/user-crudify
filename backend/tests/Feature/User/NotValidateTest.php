<?php

use App\Models\User;
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
            ]);
    });
    it('should validate data to return 422 when updating a user', function () {
        $data = [
            'name'      => '',
        ];
        $this->putJson(route('users.update', ['user' => $this->user->id]), $data, [
            'Authorization' => "Bearer {$this->token}"
        ])->assertStatus(422)->assertJsonValidationErrors([
            'name' => trans('validation.required', ['attribute' => 'name']),
        ]);
    });
});