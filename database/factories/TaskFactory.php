<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(['todo', 'in_progress', 'review', 'done', 'cancelled']),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
            'start_date' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
            'due_date' => fake()->optional()->dateTimeBetween('now', '+2 months'),
            'estimated_hours' => fake()->randomFloat(2, 1, 40),
            'actual_hours' => fake()->randomFloat(2, 0, 20),
            'order' => fake()->numberBetween(0, 100),
        ];
    }
}
