<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    // Affiche le formulaire de création
    public function showForm()
    {
        return view('exercise.create');
    }

    // Enregistre un nouvel exercice en base
    public function createExo(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|string',
            'duration'    => 'nullable|integer',
            'weight'      => 'nullable|integer',
            'distance'    => 'nullable|integer',
            'repetition'  => 'nullable|integer',
        ]);

        Exercise::create([
            'name'        => $request->name,
            'description' => $request->description,
            'distance'    => $request->distance,
            'weight'      => $request->weight,
            'duration'    => $request->duration,
            'repetition'  => $request->repetition,
            'type'        => $request->type
        ]);

        return redirect()->route('exercises.create')->with('success', 'Exercice créé avec succès ✅');
    }

    // Affiche la liste des exercices
    public function list()
    {
        $exercises = Exercise::all();
        return view('exercise.index', compact('exercises'));
    }
}
