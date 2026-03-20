<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class CustomerPermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // create permissions
        Permission::create(['name' => 'view customers']);
        Permission::create(['name' => 'create customers']);
        Permission::create(['name' => 'update customers']);
        Permission::create(['name' => 'delete customers']);

        // create role
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }

    public function test_admin_can_create_customer()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/customers', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '09999999999',
            'note' => 'Test note'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('customers', [
            'name' => 'Test User'
        ]);
    }
}
