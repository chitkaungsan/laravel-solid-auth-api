<?php
use App\Models\Customer;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

uses(RefreshDatabase::class);
test('Customer store test', function () {
    config(['auth.defaults.guard' => 'sanctum']);

    $permision = Permission::create(['name' => 'create customers']);
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo($permision);
    $user = User::factory()->create();
    $user->assignRole($role);
    Sanctum::actingAs($user);
    $response = $this->postJson('/api/v1/customers', [
        'name' => 'test',
        'email' => 'test@gmail.com',
        'phone' => '01010101010',
        'address' => 'test address',
    ]);
    $response->assertStatus(201);
});
