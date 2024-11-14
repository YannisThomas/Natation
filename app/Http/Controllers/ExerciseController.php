<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;
use App\Models\Category;

class ExerciseController extends Controller
{

    public function showForm()
    {
        $categories = Category::all();
        return View('exercise/creation', ['categories' => $categories]);
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
            'category_id' => $request->category_id,

        ]);

        return redirect('/exercice/liste');
    }
    public function listeExercice()
    {
        $exercise = Exercise::all();
        return view('exercise.voir', ['exercises' => $exercise]);
    }
}
