<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('update profile validation fails', function () {

    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/v1/profile', [
        'name' => '',
        'email' => 'not-email'
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name','email']);
});
