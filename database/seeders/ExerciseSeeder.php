<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $programs = Program::factory(10)->create();
        $exercises = Exercise::factory(10)->create();
        foreach ($exercises as $exercises) {
            $exercises->programs()->attach($programs->random(3));
        }
    }
}
