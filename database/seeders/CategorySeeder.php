<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Exécute les insertions dans la table categories.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Étirement'],
            ['id' => 2, 'name' => 'Cardio'],
            ['id' => 3, 'name' => 'Vitesse'],
            ['id' => 4, 'name' => 'Haut du corps'],
            ['id' => 5, 'name' => 'Bas du corps'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['id' => $category['id']], // Condition pour éviter les doublons
                ['name' => $category['name']]
            );
        }
    }
}
