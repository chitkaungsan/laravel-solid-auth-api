<?php
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


uses( RefreshDatabase::class);

test('user can update tour', function () {

    config(['auth.defaults.guard' => 'sanctum']);
    $permission = Permission::create(['name' => 'update tours', 'guard_name' => 'sanctum']);
    $role = Role::create(['name' => 'admin', 'guard_name' => 'sanctum']);
    $role->givePermissionTo($permission);
    $user = User::factory()->create();
    $user->assignRole($role);

    $tour = Tour::factory()->create([
        'name' => 'old tour',
        'description' => 'old description',
        'price' => 100,
    ]);

    $data = [
        'name' => 'Updated Tour',
        'description' => 'Updated description',
        'price' => 200,
    ];

    $response = $this->actingAs($user)->putJson("/api/v1/tours/{$tour->id}", $data);
    $response->assertStatus(200);

    $response = $this->assertDatabaseHas('tours', [
        'name' => 'Updated Tour',
        'description' => 'Updated description',
        'price' => 200,
    ]);


});
