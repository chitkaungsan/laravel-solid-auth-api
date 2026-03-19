<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('login fails with wrong password', function () {

    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password')
    ]);

    $response = $this->postJson('/api/v1/login',[
        'email' => 'test@gmail.com',
        'password' => 'wrongpassword'
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'message' => 'Invalid credentials'
        ]);
});
