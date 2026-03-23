<?php

use App\Models\Tour;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('can show a tour', function () {

    // 🔥 Fix guard globally
    config(['auth.defaults.guard' => 'sanctum']);



    // Create permission
    $permission = Permission::create([
        'name' => 'view tours',
        'guard_name' => 'sanctum'
    ]);

    // Create role and assign permission
    $role = Role::create([
        'name' => 'admin',
        'guard_name' => 'sanctum'
    ]);
    $role->givePermissionTo($permission);

    // Create user and assign role
    $user = User::factory()->create();
    $user->assignRole($role);

    // Authenticated as user
    Sanctum::actingAs($user, ['*'], 'sanctum');

    // Create tour
    $tour = Tour::factory()->create();

    // Send request
    $response = $this->getJson("/api/v1/tours/{$tour->id}");

    $response->assertStatus(200);
});

test('can show a tour with correct data', function () {
    config(['auth.defaults.guard' => 'sanctum']);

    $tour = Tour::factory()->create([
        'name' => 'Island Tour',
        'description' => 'Visit islands',
        'price' => 100,
    ]);
    $permission = Permission::create([
        'name' => 'view tours',
        'guard_name' => 'sanctum'
    ]);
    $role = Role::create([
        'name' => 'admin',
        'guard_name' => 'sanctum'
    ]);
    $role->givePermissionTo($permission);
    $user = User::factory()->create();
    $user->assignRole($role);
    Sanctum::actingAs($user, ['*'], 'sanctum');

    $response = $this->getJson("/api/v1/tours/{$tour->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'name' => 'Island Tour',
            'description' => 'Visit islands',
            'price' => 100,
        ]);
});
test('return 404 if tour not found', function () {
    config(['auth.defaults.guard' => 'sanctum']);
    $permission = Permission::create([
        'name' => 'view tours',
        'guard_name' => 'sanctum'
    ]);
    $role = Role::create([
        'name' => 'admin',
        'guard_name' => 'sanctum'
    ]);
    $role->givePermissionTo($permission);
    $user = User::factory()->create();
    $user->assignRole($role);

    Sanctum::actingAs($user, ['*'], 'sanctum');

    $response = $this->getJson('/api/v1/tours/100');
    $response->assertStatus(404);
});

test('tour with permission test', function () {
    config(['auth.defaults.guard' => 'sanctum']);
    $permission = Permission::create([
        'name' => 'view tours',
        'guard_name' => 'sanctum'
    ]);
    $role = Role::create([
        'name' => 'admin',
        'guard_name' => 'sanctum'
    ]);
    $role->givePermissionTo($permission);

    $user = User::factory()->create();
    $user->assignRole($role);

    Sanctum::actingAs($user, ['*'], 'sanctum');

    $tour = Tour::factory()->create();

    $response = $this->getJson("/api/v1/tours/{$tour->id}");
    $response->assertStatus(200);
});
