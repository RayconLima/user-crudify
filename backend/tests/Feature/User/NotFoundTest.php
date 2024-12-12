<?php

use App\Models\User;

beforeEach(function () {
    $this->nonExistentUserId = 99999;
    $this->user   = User::factory()->create();
    $this->token  = $this->user->createToken('auth_token')->plainTextToken;
    $this->header = [
        'Authorization' => "Bearer {$this->token}"
    ];
});

describe('Not found', function() {
    test('should return 404 when user not found', function () {
        $this->getJson(route('users.show', $this->nonExistentUserId), $this->header)->assertNotFound();
    });
    it('should return 404 when no user can be found to delete', function() {
        $this->deleteJson(route('users.destroy', $this->nonExistentUserId), [], $this->header)->assertNotFound();
    });
});