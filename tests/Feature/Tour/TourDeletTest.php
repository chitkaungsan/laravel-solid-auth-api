<?php

use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

test("Can user delete test", function () {

    // 🔥 Fix guard globally
    config(['auth.defaults.guard' => 'sanctum']);

    // 🔥 Clear cache
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    // Create permission
    $permission = Permission::create([
        'name' => 'delete tours',
        'guard_name' => 'sanctum'
    ]);

    // Create role
    $role = Role::create([
        'name' => 'admin',
        'guard_name' => 'sanctum'
    ]);

    $role->givePermissionTo($permission);

    // Create user
    $user = User::factory()->create();
    $user->assignRole($role);

    // Create tour
    $tour = Tour::factory()->create();

    // Auth
    Sanctum::actingAs($user, ['*'], 'sanctum');

    // Request
    $response = $this->deleteJson("/api/v1/tours/{$tour->id}");

    $response->assertNoContent();
});
