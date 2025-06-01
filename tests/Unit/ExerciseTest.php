<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Exercise;
use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExerciseTest extends TestCase
{
    use RefreshDatabase;

    public function test_exercise_belongs_to_many_programs()
    {
        $category = Category::factory()->create();
        // Create an exercise
        $exercise = Exercise::factory()->create();

        // Create some programs
        $programs = Program::factory()->count(3)->create();

        // Attach programs to the exercise
        $exercise->programs()->attach($programs);

        // Assert the relationship exists and returns a collection
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $exercise->programs);

        // Assert the correct number of programs are attached
        $this->assertEquals(3, $exercise->programs->count());

        // Assert each item in the relationship is a Program model
        $exercise->programs->each(function ($program) {
            $this->assertInstanceOf(Program::class, $program);
        });
    }

    public function test_exercise_belongs_to_category()
    {
        $category = Category::factory()->create();
        $exercise = Exercise::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(Category::class, $exercise->category);
        $this->assertEquals($category->id, $exercise->category->id);
    }
}
