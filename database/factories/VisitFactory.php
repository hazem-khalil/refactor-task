<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'receipt' => fake()->randomFloat(2, 0, 100),
            'member_id' => \App\Models\Member::factory()->create(),
            'cashier_id' => \App\Models\Cashier::factory()->create(),
        ];
    }
}
