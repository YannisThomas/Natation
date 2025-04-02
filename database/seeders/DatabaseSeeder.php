<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Insérer les rôles avant les utilisateurs
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'name' => 'Super Admin'],
            ['id' => 2, 'name' => 'Admin'],
            ['id' => 3, 'name' => 'Coach'],
            ['id' => 4, 'name' => 'Sportif'],
        ]);

        // ✅ Créer un utilisateur avec `firstname` et `lastname`
        User::factory()->create([
            'firstname' => 'Test', // ✅ Remplace `name` par `firstname`
            'lastname' => 'User',  // ✅ Ajoute `lastname`
            'email' => 'test@example.com',
            'phone' => '0600000000',
            'password' => Hash::make('password'),
            'role_id' => 1, // Super Admin
            'coach_id' => null, // Aucun coach
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        
        ]);
        DB::table('exercise')->insert([
            [
                'name' => 'Nage libre rapide',
                'type' => 'natation',
                'duration' => 600, // en secondes (10 min)
                'description' => 'Sprint de nage libre à haute intensité.',
                'distance' => 500, // mètres
                'weight' => null,
                'repetition' => 4,
            ],
            [
                'name' => 'Dos crawlé technique',
                'type' => 'natation',
                'duration' => 900,
                'description' => 'Travail de la technique du dos crawlé.',
                'distance' => 600,
                'weight' => null,
                'repetition' => 3,
            ],
            [
                'name' => 'Papillon puissance',
                'type' => 'natation',
                'duration' => 300,
                'description' => 'Séries courtes de papillon avec maximum d’intensité.',
                'distance' => 200,
                'weight' => null,
                'repetition' => 6,
            ],
            [
                'name' => 'Brasse récupération',
                'type' => 'natation',
                'duration' => 600,
                'description' => 'Nage en brasse pour récupération active.',
                'distance' => 400,
                'weight' => null,
                'repetition' => 2,
            ],
            [
                'name' => 'Palmes crawl',
                'type' => 'natation',
                'duration' => 1200,
                'description' => 'Crawl avec palmes pour améliorer l’endurance.',
                'distance' => 800,
                'weight' => null,
                'repetition' => 5,
            ],
        ]);
    }
}
