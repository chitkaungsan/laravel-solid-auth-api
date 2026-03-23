<?php
use App\Models\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);
test('Can customer show all', function () {

    config(['auth.defaults.guard' => 'sanctum']);

    $permission = Permission::create(['name' => 'view customers']);
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo($permission);


    $user = User::factory()->create();
    $user->assignRole($role);
    $customer = Customer::factory(5)->create();
    Sanctum::actingAs($user);
    $response = $this->getJson("/api/v1/customers");
    $response->assertOk();
});
