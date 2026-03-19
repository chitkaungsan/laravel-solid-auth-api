<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can update profile', function () {

    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/v1/profile', [
        'name' => 'New Name',
        'email' => 'newemail@gmail.com'
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'New Name',
                'email' => 'newemail@gmail.com'
            ]
        ]);
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'New Name'
    ]);
});
