<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login validation fails when email missing', function () {

    $response = $this->postJson('/api/login',[
        'password' => 'password'
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('email');
});
