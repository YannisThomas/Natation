<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProgramVoirTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/programmes/voir');

        $response->assertStatus(200);
    }
}
