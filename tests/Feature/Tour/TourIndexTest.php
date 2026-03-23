<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Laravel\Sanctum\Sanctum;

uses( RefreshDatabase::class);

test('can get tours', function(){

config(['auth.defaults.guard' => 'sanctum']);

$permission = Permission::create(['name' => 'view tours', 'guard_name' => 'sanctum']);
$role = Role::create(['name' => 'admin', 'guard_name' => 'sanctum']);
$role->givePermissionTo($permission);
$user = User::factory()->create();
$user->assignRole($role);
Sanctum::actingAs($user, ['*'], 'sanctum');
$response = $this->getJson('/api/v1/tours');
$response->assertStatus(200);

});
