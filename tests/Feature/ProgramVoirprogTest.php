<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ProgramVoirprogTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $program = \App\Models\Program::factory()->create();
        echo 'prog id'.$program->id;
        echo '-url:'.'/programmes/voir/'. $program->id;
        $response = $this->get('/programmes/voir/' . $program->id);

        $response->assertStatus(200);
    }
}
