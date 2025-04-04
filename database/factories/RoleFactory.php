<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Par défaut, on utilise sportif comme valeur par défaut
        return [
            'name' => 'sportif',
        ];
    }

    // Méthode pour créer un rôle admin
    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            return ['name' => 'admin'];
        });
    }

    // Méthode pour créer un rôle coach
    public function coach(): static
    {
        return $this->state(function (array $attributes) {
            return ['name' => 'coach'];
        });
    }
}
