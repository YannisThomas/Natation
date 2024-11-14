<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;

class ExerciseController extends Controller
{

    public function showForm()
    {
        return View('exercise/creation');
    }

    public function creationExo(ExerciseRequest $request)
    {

        $exercise = Exercise::create([
            'name' => $request->name,
            'description' => $request->description,
            'distance' => $request->distance,
            'weight' => $request->weight,
            'duration' => $request->duration,
            'repetition' => $request->repetition,
            'type' => $request->type
        ]);

        return redirect('/exercice/liste');
    }
    public function listeExercice()
    {
        $exercise = Exercise::all();
        return view('exercise.voir', ['exercises' => $exercise]);
    }
}
