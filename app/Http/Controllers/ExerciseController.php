<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExerciseRequest;
use App\Models\Category;
use App\Models\Exercise;

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
        // Les admin et coach peuvent voir tous les exercices
        if (auth()->user()->isAdmin() || auth()->user()->isCoach()) {
            $exercises = Exercise::all();
        } else {
            // Les sportifs ne peuvent voir que les exercices dans leurs programmes
            $user = auth()->user();
            $programIds = $user->programs()->pluck('id');

            // Récupère tous les exercices des programmes de l'athlète
            $exercises = Exercise::whereHas('programs', function ($query) use ($programIds) {
                $query->whereIn('programs.id', $programIds);
            })->get();
        }

        return view('exercise.voir', ['exercises' => $exercises]);
    }
}
