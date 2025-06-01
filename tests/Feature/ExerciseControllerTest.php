<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExerciseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_exercise_creation_redirects_to_list()
    {
        $category = \App\Models\Category::factory()->create();

        $exerciseData = [
            'name' => 'Push-upstest',
            'description' => 'Basic push-ups',
            'distance' => null,
            'weight' => null,
            'duration' => null,
            'repetition' => 10,
            'category_id' => $category->id,
        ];

        $response = $this->post('/exercice/creation', $exerciseData);

        $response->assertRedirect('/exercice/liste');
    }
}
