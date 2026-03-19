<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot update profile', function () {

    $response = $this->putJson('/api/v1/profile', [
        'name' => 'New Name',
        'email' => 'test@gmail.com'
    ]);

    $response->assertStatus(401);
});
