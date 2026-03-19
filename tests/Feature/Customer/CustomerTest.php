<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class CustomerPermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    protected function authenticateWithPermission()
    {
        // create permission FIRST
        $permission = Permission::create([
            'name' => 'create customers',
            'guard_name' => 'web'
        ]);

        // then user
        $user = User::factory()->create();

        // assign permission
        $user->givePermissionTo($permission);

        Sanctum::actingAs($user, [], 'web');

        return $user;
    }

    public function test_user_with_permission_can_create_customer()
    {
        $this->authenticateWithPermission();

        $response = $this->postJson('/api/v1/customers', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '0812345678',
            'note' => 'Test note'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('customers', [
            'email' => 'john@example.com'
        ]);
    }
}
