<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TourStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_tour()
    {
        $data = [
            'name' => 'Island Tour',
            'description' => 'Visit islands',
            'price' => 100,
        ];

        $response = $this->postJson('/api/v1/tours', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tours', [
            'name' => 'Island Tour',
        ]);
    }
}
