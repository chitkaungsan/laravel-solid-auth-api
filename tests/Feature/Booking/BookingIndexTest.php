<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('Can booking index', function () {
        config(['auth.defaults.guard' => 'sanctum']);
        $permission = Permission::create(['name' => 'view bookings']);
        $role= Role::create(['name' => 'admin']);
        $role->givePermissionTo($permission);
        $user = User::factory()->create();
        $user->assignRole($role);
        Sanctum::actingAs($user);
        $response = $this->getJson('/api/v1/bookings');
        $response->assertStatus(200);
});
