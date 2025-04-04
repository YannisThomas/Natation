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
