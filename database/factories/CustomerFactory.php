<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;
    public function definition(): array
    {
            return [
            'name' => $this->faker->words(2, true),
            'email' => $this->faker->email(),
            'phone' => $this->faker->numberBetween(50, 500),
            'note' => $this->faker->sentence(),
        ];
    }
}
