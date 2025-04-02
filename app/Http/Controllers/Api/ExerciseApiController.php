<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExerciseApiController extends Controller
{
    public function postExercise(Request $request)
    {
        return response()->json([
            'success' => true,

        ]);
    }
}
