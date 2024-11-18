<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Exercise;
use App\Models\Category;

class ExerciceCreationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $category = Category::factory()->create();
        $exercice = Exercise::factory()->create();

        $response = $this->get('/exercice/creation');

        $response2 = $this->post('/exercice/creation', [
            'name' => $exercice->name,
            'duration' => $exercice->duration,
            'description' => $exercice->description,
            'distance' => $exercice->distance,
            'weight' => $exercice->weight,
            'repetition' => $exercice->repetition,
            'category_id' => $category->id,

        ]);


        $response->assertStatus(200);
        $response2->assertStatus(302);
    }
}
