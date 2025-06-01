<?php

namespace Tests\Feature;

use Tests\TestCase;

use function Illuminate\Types\Builder\test;

class ExerciseVoirTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/exercice/liste');

        $response->assertStatus(200);
    }
}
