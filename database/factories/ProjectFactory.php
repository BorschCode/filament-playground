<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-6 months', 'now');
        $dueDate = fake()->dateTimeBetween($startDate, '+1 year');

        return [
            'name' => fake()->bs(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['planning', 'active', 'on_hold', 'completed', 'cancelled']),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
            'start_date' => $startDate,
            'due_date' => $dueDate,
            'budget' => fake()->randomFloat(2, 10000, 500000),
            'actual_cost' => fake()->randomFloat(2, 0, 100000),
            'progress' => fake()->numberBetween(0, 100),
        ];
    }
}
