<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExerciseProgram; // Import du modèle

class ProgramApiController extends Controller
{

    /**
     * Affiche les détails d'un programme.
     * 
     * @param string $programId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $programId)
    {
        $program = ExerciseProgram::find($programId);

        if (!$program) {
            return response()->json(['error' => 'Programme non trouvé'], 404);
        }

        return response()->json($program);
    }

    /**
     * Marque un exercice comme terminé.
     * 
     * @param int $program
     * @param int $exercise
     * @return \Illuminate\Http\JsonResponse
     */
    public function finish(int $program, int $exercise)
    {
        $exerciseProgram = ExerciseProgram::where('program_id', $program)
            ->where('exercise_id', $exercise)
            ->first();

        if (!$exerciseProgram) {
            return response()->json(['error' => "Exercice non trouvé pour ce programme"], 404);
        }

        $exerciseProgram->update(['status' => 'finished']);

        return response()->json(['message' => "Exercice marqué comme terminé"]);
    }
}
