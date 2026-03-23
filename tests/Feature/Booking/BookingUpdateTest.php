<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Laravel\Sanctum\Sanctum;
use App\Models\Booking;
use App\Models\Customer;
uses(RefreshDatabase::class);

test('Can update booking', function () {
    config(['auth.defaults.guard' => 'sanctum']);
    $permission = Permission::create(['name'=>'update bookings']);
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo($permission);

    $user = User::factory()->create();
    $user->assignRole($role);
    Sanctum::actingAs($user);
    $customer = Customer::factory()->create();
    $booking = Booking::factory()->create(['customer_id'=>$customer->id]);
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
    $response = $this->putJson('/api/v1/bookings/'.$booking->id, $data);
    $response->assertStatus(200);
});
