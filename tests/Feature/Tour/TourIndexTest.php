<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TourTest extends TestCase
{
    use RefreshDatabase;

public function test_can_get_tours()
{
    // Arrange
    Tour::factory()->count(2)->create();

    // Act
    $response = $this->getJson('/api/v1/tours');

    // Assert
    $response->assertStatus(200)
        ->assertJsonCount(2, 'data') // ✅ FIX
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price'
                ]
            ]
        ]);
}
}
