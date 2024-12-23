<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\Exercise;
use Database\Factories\ProgramFactory;
use App\Http\Requests\ProgramRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
    public function createProgram(ProgramRequest $request)
    {

        $program = Program::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,

        ]);

        $program->exercises()->attach($request->input('exercise_id'));
        return redirect()->back()->with('success', 'Program created successfully.');
    }
    public function showForm()
    {
        $users = User::all();
        $exercises = Exercise::all();
        return view('program.create', ['users' => $users], ['exercices' => $exercises]);
    }
}
