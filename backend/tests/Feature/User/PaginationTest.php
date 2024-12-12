<?php

use App\Models\User;

beforeEach(function () {
    $this->user   = User::factory()->create();
    $this->token  = $this->user->createToken('auth_token')->plainTextToken;
});

describe('pagination', function () {
    it('should return users page 2', function () {
        User::factory()->count(22)->create();
        $response = $this->getJson(route('users.index') . '?page=2', [
            'Authorization' => "Bearer {$this->token}"
        ])->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'iti',
                    'name',
                    'email',
                ]
            ],
            'meta' => [
                'total',
                'current_page',
                'from',
                'last_page',
                'links' => [],
                'path',
                'per_page',
                'to'
            ]
        ])->assertOk();

        expect(count($response['data']))->toBe(8);
        expect($response['meta']['total'])->toBe(23);
    });
    it('should return the total number of users per page', function () {
        User::factory()->count(16)->create();
        $response = $this->getJson(
            route('users.index') . '?total_per_page=4',
            [
                'Authorization' => 'Bearer ' . $this->token
            ]
        )->assertJsonStructure([
            'data' => [
                '*' => ['id', 'iti', 'name', 'email']
            ],
            'meta' => ['total', 'current_page', 'from', 'last_page', 'links' => [], 'path', 'per_page', 'to']
        ])->assertOk();

        expect(count($response['data']))->toBe(15);
        expect($response['meta']['total'])->toBe(17);
        expect($response['meta']['per_page'])->toBe(15);
    });
    test('should return the filtered user in a pagination', function () {
        User::factory()->count(20)->create();
        User::factory()->create(['name' => 'custom_name']);
        $response = $this->getJson(
            route('users.index') . "?filter=custom_name",
            [
                'Authorization' => 'Bearer ' . $this->token
            ]
        )->assertJsonStructure([
            'data' => [
                '*' => ['id', 'iti', 'name', 'email']
            ],
            'meta' => ['total', 'current_page', 'from', 'last_page', 'links' => [], 'path', 'per_page', 'to']
        ])->assertOk();

        expect(count($response['data']))->toBe(15);
        expect($response['meta']['total'])->toBe(22);
        expect($response['meta']['per_page'])->toBe(15);
    });
});