<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('user can change password', function () {

    $user = User::factory()->create([
        'password' => Hash::make('oldpassword')
    ]);

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/change-password', [
        'current_password' => 'oldpassword',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123'
    ]);

    $response->assertStatus(200);

    expect(Hash::check(
        'newpassword123',
        $user->fresh()->password
    ))->toBeTrue();
});
