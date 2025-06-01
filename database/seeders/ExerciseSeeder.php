<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Exercise;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des exercices prédéfinis de natation avec des noms réalistes
        // Exercices adaptés pour l'entraînement hors piscine selon l'annexe 9-1-B
        $exercisesData = [
            // Exercices de type Crawl
            ['name' => 'Crawl 100m', 'distance' => 100, 'duration' => 5, 'description' => 'Nage crawl sur 100 mètres à vitesse modérée.', 'type' => 'Crawl'],
            ['name' => 'Crawl 200m', 'distance' => 200, 'duration' => 10, 'description' => 'Nage crawl sur 200 mètres à vitesse constante.', 'type' => 'Crawl'],
            ['name' => 'Crawl sprint 50m', 'distance' => 50, 'duration' => 2, 'description' => 'Sprint crawl à vitesse maximale sur 50 mètres.', 'type' => 'Crawl'],
            ['name' => 'Crawl technique', 'distance' => 150, 'duration' => 15, 'description' => 'Travail technique sur la position des bras et la respiration en crawl.', 'type' => 'Crawl'],

            // Exercices de type Brasse
            ['name' => 'Brasse 100m', 'distance' => 100, 'duration' => 6, 'description' => 'Nage brasse sur 100 mètres à vitesse modérée.', 'type' => 'Brasse'],
            ['name' => 'Brasse 200m', 'distance' => 200, 'duration' => 12, 'description' => 'Nage brasse sur 200 mètres à vitesse constante.', 'type' => 'Brasse'],
            ['name' => 'Brasse technique', 'distance' => 150, 'duration' => 15, 'description' => 'Travail sur la synchronisation des mouvements en brasse.', 'type' => 'Brasse'],

            // Exercices de type Dos
            ['name' => 'Dos 100m', 'distance' => 100, 'duration' => 6, 'description' => 'Nage dos sur 100 mètres à vitesse modérée.', 'type' => 'Dos'],
            ['name' => 'Dos 200m', 'distance' => 200, 'duration' => 12, 'description' => 'Nage dos sur 200 mètres à vitesse constante.', 'type' => 'Dos'],
            ['name' => 'Dos technique', 'distance' => 150, 'duration' => 15, 'description' => 'Travail sur la position du corps et la rotation des épaules en dos.', 'type' => 'Dos'],

            // Exercices de type Papillon
            ['name' => 'Papillon 50m', 'distance' => 50, 'duration' => 3, 'description' => 'Nage papillon sur 50 mètres.', 'type' => 'Papillon'],
            ['name' => 'Papillon 100m', 'distance' => 100, 'duration' => 7, 'description' => 'Nage papillon sur 100 mètres à vitesse modérée.', 'type' => 'Papillon'],
            ['name' => 'Papillon technique', 'distance' => 100, 'duration' => 12, 'description' => 'Travail sur le mouvement des bras et la coordination en papillon.', 'type' => 'Papillon'],

            // Exercices de renforcement
            ['name' => 'Battements de jambes', 'repetition' => 20, 'duration' => 5, 'description' => 'Battements de jambes avec planche pour renforcer les muscles des jambes.', 'type' => 'Renforcement'],
            ['name' => 'Pullbuoy', 'distance' => 100, 'duration' => 7, 'description' => 'Nage avec pullbuoy pour renforcer les bras et le haut du corps.', 'type' => 'Renforcement'],
            ['name' => 'Planche ventrale', 'duration' => 3, 'repetition' => 3, 'description' => 'Exercice de gainage pour renforcer les abdominaux.', 'type' => 'Renforcement'],
            ['name' => 'Exercice avec élastiques', 'repetition' => 15, 'duration' => 5, 'description' => 'Renforcement des épaules avec élastiques.', 'type' => 'Renforcement'],

            // Exercices d'endurance
            ['name' => '4 x 50m', 'distance' => 200, 'duration' => 10, 'description' => '4 répétitions de 50 mètres avec 15 secondes de récupération.', 'type' => 'Endurance'],
            ['name' => '8 x 25m', 'distance' => 200, 'duration' => 12, 'description' => '8 répétitions de 25 mètres avec 10 secondes de récupération.', 'type' => 'Endurance'],
            ['name' => 'Pyramide 50-100-150-100-50', 'distance' => 450, 'duration' => 25, 'description' => 'Série en pyramide pour travailler l\'endurance.', 'type' => 'Endurance'],

            // EXERCICES HORS PISCINE - Conformément à l'annexe 9-1-B
            // "exercices pouvant être pratiqués hors des bassins"
            
            // Préparation physique terre
            ['name' => 'Course à pied 30 min', 'duration' => 30, 'description' => 'Course d\'endurance pour développer la capacité cardio-vasculaire. Alternative hors piscine.', 'type' => 'Hors Piscine'],
            ['name' => 'Vélo d\'appartement', 'duration' => 25, 'description' => 'Entraînement cardio sur vélo stationnaire, travail des jambes.', 'type' => 'Hors Piscine'],
            ['name' => 'Rameur 20 min', 'duration' => 20, 'description' => 'Simulation du mouvement de nage sur rameur, excellent pour la technique.', 'type' => 'Hors Piscine'],
            
            // Renforcement musculaire sec
            ['name' => 'Pompes spécial nageur', 'repetition' => 20, 'duration' => 5, 'description' => 'Pompes avec variation pour renforcer les muscles utilisés en natation.', 'type' => 'Hors Piscine'],
            ['name' => 'Squats aquatiques', 'repetition' => 25, 'duration' => 8, 'description' => 'Squats pour renforcer les jambes, mouvement adapté aux nageurs.', 'type' => 'Hors Piscine'],
            ['name' => 'Gainage planche', 'duration' => 2, 'repetition' => 5, 'description' => 'Planche pour renforcer le core, essentiel pour la position en natation.', 'type' => 'Hors Piscine'],
            ['name' => 'Élastiques bras', 'repetition' => 15, 'duration' => 10, 'description' => 'Exercices avec élastiques pour simuler les mouvements de nage.', 'type' => 'Hors Piscine'],
            
            // Mobilité et technique
            ['name' => 'Étirements nageur', 'duration' => 15, 'description' => 'Séance d\'étirements spécifiques pour les nageurs, améliore la souplesse.', 'type' => 'Hors Piscine'],
            ['name' => 'Yoga aquatique', 'duration' => 30, 'description' => 'Postures de yoga adaptées pour améliorer la flexibilité et la respiration.', 'type' => 'Hors Piscine'],
            ['name' => 'Exercices respiratoires', 'repetition' => 10, 'duration' => 8, 'description' => 'Travail de la respiration et de l\'apnée, technique fondamentale.', 'type' => 'Hors Piscine'],
            
            // Préparation mentale
            ['name' => 'Visualisation technique', 'duration' => 10, 'description' => 'Exercice de visualisation des mouvements de nage, préparation mentale.', 'type' => 'Hors Piscine'],
            ['name' => 'Méditation sportive', 'duration' => 15, 'description' => 'Méditation pour améliorer la concentration et gérer le stress de compétition.', 'type' => 'Hors Piscine'],
        ];

        // Créer des catégories pertinentes pour la natation si elles n'existent pas déjà
        $categories = [
            'Crawl', 'Brasse', 'Dos', 'Papillon', 'Renforcement', 'Endurance', 'Hors Piscine',
        ];

        $categoryIds = [];

        foreach ($categories as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $categoryIds[$categoryName] = $category->id;
        }

        // Insérer les exercices prédéfinis
        foreach ($exercisesData as $exerciseData) {
            $type = $exerciseData['type'];
            unset($exerciseData['type']);

            Exercise::create(array_merge($exerciseData, [
                'category_id' => $categoryIds[$type],
                'weight' => isset($exerciseData['repetition']) ? rand(1, 5) : 0,
            ]));
        }

        // Ajouter quelques exercices aléatoires supplémentaires pour diversifier
        foreach (Category::all() as $category) {
            // Ajouter 1-3 exercices aléatoires par catégorie
            Exercise::factory(rand(1, 3))->create([
                'category_id' => $category->id,
            ]);
        }
    }
}
