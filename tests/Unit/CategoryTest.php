<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_category_has_many_exercises()
    {
        $category = Category::factory()->create();
        Exercise::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Collection::class, $category->exercises);
        $this->assertCount(3, $category->exercises);
    }
}
