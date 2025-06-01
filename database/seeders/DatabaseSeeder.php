<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création des catégories
        Category::factory(5)->create();

        // Création des rôles
        $adminRole = Role::factory()->admin()->create();
        $coachRole = Role::factory()->coach()->create();
        $sportifRole = Role::factory()->create(); // Par défaut c'est sportif

        // Création d'un utilisateur admin
        User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('test1234'),
            'role_id' => $adminRole->id,
        ]);

        // Création de 3 profils pour les examinateurs
        $examinerAdmin = User::factory()->create([
            'firstname' => 'Examinateur',
            'lastname' => 'Admin',
            'email' => 'examiner.admin@test.com',
            'password' => bcrypt('examiner123'),
            'role_id' => $adminRole->id,
        ]);

        $examinerCoach = User::factory()->create([
            'firstname' => 'Examinateur',
            'lastname' => 'Coach',
            'email' => 'examiner.coach@test.com',
            'password' => bcrypt('examiner123'),
            'role_id' => $coachRole->id,
        ]);

        $examinerAthlete = User::factory()->create([
            'firstname' => 'Examinateur',
            'lastname' => 'Athlete',
            'email' => 'examiner.athlete@test.com',
            'password' => bcrypt('examiner123'),
            'role_id' => $sportifRole->id,
        ]);

        // 2 coachs
        $coaches = User::factory(2)->create([
            'role_id' => $coachRole->id,
        ]);

        // 7 sportifs
        $athletes = User::factory(7)->create([
            'role_id' => $sportifRole->id,
        ]);

        // Exécution des seeders
        $this->call([
            RoleSeeder::class,       // Assurez-vous que les rôles existent d'abord
            ExerciseSeeder::class,   // Puis créer les exercices
        ]);

        // Récupérer tous les exercices pour les associer aux programmes
        $exercises = \App\Models\Exercise::all();

        // Créer un programme spécifique pour l'examinateur athlète
        $examinerProgram = \App\Models\Program::factory()->create([
            'user_id' => $examinerAthlete->id,
            'coach_id' => $examinerCoach->id,
            'name' => 'Programme de test pour examinateur',
            'description' => 'Programme spécialement conçu pour tester toutes les fonctionnalités',
        ]);

        // Attacher quelques exercices spécifiques avec différents états
        $examinerExercises = $exercises->take(5);
        foreach ($examinerExercises as $index => $exercise) {
            $finishedAt = null;
            $performanceData = [];
            
            // Premier exercice terminé avec données complètes
            if ($index === 0) {
                $finishedAt = now()->subDays(2)->format('Y-m-d');
                $performanceData = [
                    'duration_completed' => 1800,
                    'distance_completed' => 2000.50,
                    'repetitions_completed' => 40,
                    'weight_used' => 75.5,
                    'notes' => 'Exercice terminé avec succès par l\'examinateur',
                    'gps_data' => json_encode([
                        ['latitude' => 48.856614, 'longitude' => 2.352222, 'timestamp' => now()->subDays(2)->toISOString()],
                        ['latitude' => 48.857614, 'longitude' => 2.353222, 'timestamp' => now()->subDays(2)->addMinutes(10)->toISOString()]
                    ])
                ];
            }
            // Deuxième exercice terminé avec données partielles
            elseif ($index === 1) {
                $finishedAt = now()->subDays(1)->format('Y-m-d');
                $performanceData = [
                    'duration_completed' => 900,
                    'notes' => 'Exercice terminé rapidement'
                ];
            }
            // Les autres exercices restent non terminés pour les tests
            
            $examinerProgram->exercises()->attach($exercise->id, array_merge([
                'finished_at' => $finishedAt,
            ], $performanceData));
        }

        // Assigner chaque sportif à un coach aléatoire en créant un programme
        foreach ($athletes as $athlete) {
            $coach = $coaches->random();

            // Créer un programme pour chaque sportif
            $program = \App\Models\Program::factory()->create([
                'user_id' => $athlete->id,
                'coach_id' => $coach->id,
                'name' => 'Programme d\'entraînement de '.$athlete->firstname,
                'description' => 'Programme personnalisé créé pour '.$athlete->firstname.' '.$athlete->lastname,
            ]);

            // Attacher 3 à 6 exercices aléatoires à ce programme
            $randomExercises = $exercises->random(rand(3, 6));
            foreach ($randomExercises as $exercise) {
                // Possibilité aléatoire que certains exercices soient marqués comme terminés
                $finishedAt = rand(0, 1) ? now()->subDays(rand(1, 10))->format('Y-m-d') : null;

                $program->exercises()->attach($exercise->id, [
                    'finished_at' => $finishedAt,
                ]);
            }
        }

        // Créer quelques programmes additionnels pour certains athlètes (programmes historiques)
        for ($i = 0; $i < 5; $i++) {
            $athlete = $athletes->random();
            $coach = $coaches->random();

            $startDate = now()->subMonths(rand(2, 12));
            $endDate = (clone $startDate)->addWeeks(rand(4, 12));

            $program = \App\Models\Program::factory()->create([
                'user_id' => $athlete->id,
                'coach_id' => $coach->id,
                'name' => 'Programme précédent de '.$athlete->firstname,
                'description' => 'Programme d\'entraînement précédent terminé',
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]);

            // Attacher 3 à 8 exercices aléatoires à ce programme historique
            // Tous les exercices sont marqués comme terminés
            $randomExercises = $exercises->random(rand(3, 8));
            foreach ($randomExercises as $exercise) {
                $program->exercises()->attach($exercise->id, [
                    'finished_at' => $endDate->subDays(rand(1, 14))->format('Y-m-d'),
                ]);
            }
        }
    }
}
