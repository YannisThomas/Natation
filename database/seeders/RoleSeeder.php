<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des rôles de base nécessaires pour l'application
        $roles = [
            ['name' => 'admin'],
            ['name' => 'coach'],
            ['name' => 'sportif']
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
