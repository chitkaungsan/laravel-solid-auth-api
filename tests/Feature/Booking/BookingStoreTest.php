<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Laravel\Sanctum\Sanctum;
use App\Models\Booking;
use App\Models\Customer;
uses(RefreshDatabase::class);
test('Booking store', function () {
    config(['auth.defaults.guard' => 'sanctum']);
    $user = User::factory()->create();
    $permission = Permission::create(['name' => 'create bookings']);
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo($permission);
    $user->assignRole($role);
    Sanctum::actingAs($user);
    // Booking::factory()->count(10)->create();
    $customer = Customer::factory()->create();
    $data = [
        'customer_id'   => $customer->id,
        'service_name'  => 'Island Tour',
        'booking_date'  => '2026-04-05',
        'booking_time'  => '10:30:00',
        'people_count'  => 2,
        'price'         => 150.00,
        'status'        => 'pending',
        'note'          => 'Customer requested snorkeling equipment.',
        'created_at'    => now(),
        'updated_at'    => now(),
    ];
    $response = $this->postJson('/api/v1/bookings', $data);

    $response->assertStatus(201);
});
