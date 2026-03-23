<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Booking::class;
    public function definition(): array
    {
        return [
            'customer_id' => 1,
            'service_name' => $this->faker->words(2, true),
            'booking_date' => $this->faker->date(),
            'booking_time' => $this->faker->time(),
            'people_count' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(50, 500),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'note' => $this->faker->sentence(),
        ];
    }
}
