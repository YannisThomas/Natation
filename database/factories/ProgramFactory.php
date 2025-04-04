<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Programme '.fake()->words(3, true),
            'start_date' => fake()->dateTimeBetween('now', '+1 week')->format('Y-m-d'),
            'end_date' => fake()->dateTimeBetween('+2 weeks', '+2 months')->format('Y-m-d'),
            'user_id' => User::factory(),
            'coach_id' => function () {
                return \App\Models\User::whereHas('role', function ($query) {
                    $query->where('name', 'coach');
                })->inRandomOrder()->first()?->id ??
                \App\Models\User::factory()->create(['role_id' => \App\Models\Role::where('name', 'coach')->first()?->id])->id;
            },
        ];
    }

    /**
     * Définit un coach existant pour le programme
     */
    public function withExistingCoach(): static
    {
        return $this->state(function (array $attributes) {
            $coach = \App\Models\User::whereHas('role', function ($query) {
                $query->where('name', 'coach');
            })->inRandomOrder()->first();

            return [
                'coach_id' => $coach ? $coach->id : null,
            ];
        });
    }
}
