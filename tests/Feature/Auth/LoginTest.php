<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can login and receive token', function () {

    $user = User::factory()->create([
        'email' => 'test@gmail.com',
        'password' => bcrypt('password')
    ]);

    $response = $this->postJson('/api/login',[
        'email' => 'test@gmail.com',
        'password' => 'password'
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'token',
            'user' => [
                'id',
                'name',
                'email'
            ]
        ]);
});
