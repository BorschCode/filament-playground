<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->catchPhrase(),
            'value' => fake()->randomFloat(2, 1000, 500000),
            'currency' => 'USD',
            'stage' => fake()->randomElement(['lead', 'qualified', 'proposal', 'negotiation', 'won', 'lost']),
            'probability' => fake()->numberBetween(0, 100),
            'expected_close_date' => fake()->dateTimeBetween('now', '+6 months'),
            'description' => fake()->paragraph(),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
