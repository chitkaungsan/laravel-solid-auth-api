<?php

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Laravel\Sanctum\Sanctum;
use App\Models\Customer;
uses(RefreshDatabase::class);
test('Delete bookings', function () {
    config(['auth.defaults.guard' => 'sanctum']);
    $permission = Permission::create(['name' => 'delete bookings']);
    $role= Role::create(['name' => 'admin']);
    $role->givePermissionTo($permission);
    $user = User::factory()->create();
    $user->assignRole($role);
    Sanctum::actingAs($user);
    $customer = Customer::factory()->create();

    $booking = Booking::factory()->create(['customer_id' => $customer->id, 'status' => 'pending']);
    $response = $this->deleteJson("/api/v1/bookings/{$booking->id}");
    $response->assertStatus(200);
});
