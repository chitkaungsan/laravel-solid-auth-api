<?php
use App\Models\Customer;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('Customer Delete', function () {
    config(['auth.defaults.guard' => 'sanctum']);

    $customer = Customer::factory()->create();
    $permission = Permission::create(['name' => 'delete customers']);
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo($permission);
    $user = User::factory()->create();
    $user->assignRole($role);
    Sanctum::actingAs($user);
    $response = $this->deleteJson("/api/v1/customers/{$customer->id}");
    $response->assertNoContent();
});
