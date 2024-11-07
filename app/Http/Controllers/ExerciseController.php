<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{

    public function showForm(){
        return View('exercise/create');
    }

    public function createExo(Request $request){
        echo $request->name;
        echo $request->description;

        $exercise = Exercise::create([
            'name'=> $request->name,
            'description'=> $request->description,
            'distance'=> $request->distance,
            'weight'=> $request->weight,
            'duration'=> $request->duration,
            'repetition'=> $request->repetition,
            'type'=> $request->type
        ]);
    }

}
