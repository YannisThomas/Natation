<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProgramApiController extends Controller
{
    public function show(string $programId)
    {
        try {
            $programs = Program::with('exercises')->findOrFail($programId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Program not found',
                'data' => $e->getMessage(),
            ], 404, [], JSON_FORCE_OBJECT);
        }

        return response()->json($programs);
    }

    public function finished(int $programId, int $exerciseId)
    {

        DB::table('exercise_program')
            ->where('exercise_id', $exerciseId)
            ->where('program_id', $programId)
            ->update(['finished_at' => Carbon::now()]);

        return response()->json([
            'message' => 'Program finished',
            'data' => $programId,
        ], 200, [], JSON_FORCE_OBJECT);
    }
}
