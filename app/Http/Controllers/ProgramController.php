<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function showPrograms()
    {
        $programs = Program::all();

        return view('program.voir', ['programs' => $programs]);
    }

    public function showExercise($programId)
    {
        $programs = Program::findOrFail($programId);
        $exercises = $programs->exercises;
        return view('program.voirprog', ['exercises' => $exercises, 'programs' => $programs]);
    }
}
