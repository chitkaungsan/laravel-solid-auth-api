<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses( RefreshDatabase::class);

test('Can store tour',function(){
    config(['auth.defaults.guard' => 'sanctum']);

    $user = User::factory()->create();
    $permission = Permission::create(['name' => 'create tours', 'guard_name' => 'sanctum']);
    $role = Role::create(['name' => 'admin', 'guard_name' => 'sanctum']);
    $role->givePermissionTo($permission);
    $user->assignRole($role);
    $response = $this->actingAs($user)->postJson('/api/v1/tours',[
        'name' => 'Test Tour',
        'description' => 'Test Description',
        'price' => 100,
    ]);
    $response->assertStatus(201);
});
