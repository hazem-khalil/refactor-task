<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loyalty>
 */
class LoyaltyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'points' => fake()->randomFloat(2, 0, 100),
            'visit_id' => \App\Models\Visit::factory()->create(),
        ];
    }
}
