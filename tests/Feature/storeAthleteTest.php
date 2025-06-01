<?php

namespace Tests\Feature;

use Tests\TestCase;

class storeAthleteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->post('/');

        $response->assertStatus(200);
    }
}
