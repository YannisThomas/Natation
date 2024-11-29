<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'duration' => fake()->numberBetween(0, 100),
            'description' => fake()->text(),
            'distance' => fake()->numberBetween(0, 100),
            'weight' => fake()->numberBetween(0, 100),
            'repetition' => fake()->numberBetween(0, 100),
            'category_id' => Category::query()->inRandomOrder()->first()->id,
            
        ];
    }
}
