<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subtask>
 */
class SubtaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_id' => rand(1, 3000),
            'name'    => fake()->word(3, true)
        ];
    }
}
