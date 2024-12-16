<?php

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->customNumber = mt_rand(10000000000, 99999999999);
    $this->user   = User::factory()->create();
    $this->token  = $this->user->createToken('auth_token')->plainTextToken;
    $this->header = [
        'Authorization' => "Bearer {$this->token}"
    ];
});

describe('status code 200', function () {
    test('should return 200', function () {
        $this->getJson(route('users.index'), [
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
        ])->assertOk();
    });

    test('should return 200 when receive many users', function () {
        User::factory()->count(20)->create();
        $response = $this->getJson(route('users.index'), [
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

        expect(count($response['data']))->toBe(15);
        expect($response['meta']['total'])->toBe(21);
    });
});

describe('CRUD - Create, Read, Update and Delete', function () {
    it('should create a new user with valid data', function () {
        $data = [
            'name'      => 'John Snow',
            'iti'       => $this->customNumber,
            'email'     => 'john@example.com',
        ];


        $response = $this->post(route('users.store'), $data, $this->header)
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
            'registration_type' => 'internal',
        ]);

    });

    it('should return user', function () {
        $this->getJson(route('users.show', $this->user->id), $this->header)->assertOk()->assertJsonStructure([
            'data' => [
                'id',
                'iti',
                'name',
                'email',
            ]
        ]);
    });

    it('Should be possible to update user', function () {
        $inputs = [
            'name'  => 'John Snow',
            'password' => 'secretPassword1',
            'password_confirmation' => 'secretPassword1',
        ];
        $this->putJson(route('users.update', $this->user->id), $inputs, $this->header)->assertOk();

        $this->assertDatabaseHas('users', [
            'id'    => $this->user->id,
            'name'  => 'John Snow',
        ]);
    });

    it('should delete user', function() {
        $this->deleteJson(route('users.destroy', $this->user->id), [], [
            'Authorization' => "Bearer {$this->token}"
        ])->assertNoContent();
        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    });

    it('Should be return 404 when cannot update user', function () {
        $nonExistentUserId = 99999;
        $inputs = [
            'name'  => 'John Snow',
            'password' => 'secretPassword1',
            'password_confirmation' => 'secretPassword1',
        ];
        $this->putJson(route('users.update', $nonExistentUserId), $inputs, $this->header)->assertNotFound();
    });
});