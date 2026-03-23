<?php
use App\Models\Customer;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
uses(RefreshDatabase::class);
test('Customer update test', function () {
    config(['auth.defaults.guard' => 'sanctum']);
    $customer = Customer::factory()->create();
    $permission = Permission::create(['name' => 'update customers']);
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo($permission);
    // $user = $customer->user;
    $user = User::factory()->create();
    $user->assignRole($role);
    Sanctum::actingAs($user);
    $response = $this->putJson("/api/v1/customers/{$customer->id}", [
        'name' => 'test',
        'email' => 'test@email.com',
        'phone' => '01010101010',
        'address' => 'test address',
    ]);
    $response->assertStatus(200);
});
