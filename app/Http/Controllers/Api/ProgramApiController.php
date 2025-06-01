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

    /**
     * @OA\Put(
     *      path="/programme/{programme}/exercice/{exercise}",
     *      operationId="validateExercise",
     *      tags={"Exercises"},
     *      summary="Validate and mark an exercise as finished",
     *      description="Endpoint to validate exercise completion with optional performance data",
     *      security={
     *          {"api_key_security_example": {}}
     *      },
     *
     *      @OA\Parameter(
     *          name="programme",
     *          in="path",
     *          description="Program ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="exercise",
     *          in="path",
     *          description="Exercise ID", 
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="user_id", type="integer", example=1, description="ID of the user completing the exercise"),
     *              @OA\Property(property="duration_completed", type="integer", example=300, description="Actual duration in seconds"),
     *              @OA\Property(property="distance_completed", type="float", example=1500.5, description="Actual distance completed"),
     *              @OA\Property(property="repetitions_completed", type="integer", example=20, description="Actual repetitions completed"),
     *              @OA\Property(property="weight_used", type="float", example=75.5, description="Weight used during exercise"),
     *              @OA\Property(property="notes", type="string", example="Exercise completed successfully", description="Additional notes"),
     *              @OA\Property(property="gps_data", type="array", @OA\Items(type="object",
     *                @OA\Property(property="latitude", type="float", example=48.856614),
     *                @OA\Property(property="longitude", type="float", example=2.352222),
     *                @OA\Property(property="timestamp", type="string", example="2024-01-01T12:00:00Z")
     *              ))
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Exercise marked as finished successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Exercise completed successfully"),
     *              @OA\Property(property="data", type="object",
     *                @OA\Property(property="program_id", type="integer", example=1),
     *                @OA\Property(property="exercise_id", type="integer", example=2),
     *                @OA\Property(property="finished_at", type="string", example="2024-01-01T12:00:00Z")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Program or exercise not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Exercise not found in this program")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Invalid input"),
     *              @OA\Property(property="details", type="object")
     *          )
     *      )
     * )
     */
    public function finished(int $programId, int $exerciseId, \Illuminate\Http\Request $request)
    {
        try {
            // Vérifier si l'utilisateur est connecté (pour les requêtes web)
            if ($request->has('user_id') && !auth()->check()) {
                return response()->json([
                    'error' => 'Authentication required',
                ], 401);
            }

            $validatedData = $request->validate([
                'user_id' => 'sometimes|integer|exists:users,id',
                'duration_completed' => 'sometimes|integer|min:0',
                'distance_completed' => 'sometimes|numeric|min:0',
                'repetitions_completed' => 'sometimes|integer|min:0',
                'weight_used' => 'sometimes|numeric|min:0',
                'notes' => 'sometimes|string|max:1000',
                'gps_data' => 'sometimes|array',
                'gps_data.*.latitude' => 'numeric|between:-90,90',
                'gps_data.*.longitude' => 'numeric|between:-180,180',
                'gps_data.*.timestamp' => 'sometimes|date',
            ]);

            $exerciseProgram = DB::table('exercise_program')
                ->where('exercise_id', $exerciseId)
                ->where('program_id', $programId)
                ->first();

            if (!$exerciseProgram) {
                return response()->json([
                    'error' => 'Exercise not found in this program',
                ], 404);
            }

            // Vérifier les permissions : seul l'athlète assigné ou un admin peut valider
            if (isset($validatedData['user_id'])) {
                $program = \App\Models\Program::findOrFail($programId);
                $user = \App\Models\User::with('role')->findOrFail($validatedData['user_id']);
                
                // Vérifier que l'utilisateur a le droit de valider cet exercice
                if (!$user->role || ($user->role->name !== 'admin' && $program->user_id !== $validatedData['user_id'])) {
                    return response()->json([
                        'error' => 'Unauthorized: You can only validate your own exercises',
                    ], 403);
                }
            }

            $finishedAt = Carbon::now();
            
            $updateData = ['finished_at' => $finishedAt];
            
            if (isset($validatedData['duration_completed'])) {
                $updateData['duration_completed'] = $validatedData['duration_completed'];
            }
            if (isset($validatedData['distance_completed'])) {
                $updateData['distance_completed'] = $validatedData['distance_completed'];
            }
            if (isset($validatedData['repetitions_completed'])) {
                $updateData['repetitions_completed'] = $validatedData['repetitions_completed'];
            }
            if (isset($validatedData['weight_used'])) {
                $updateData['weight_used'] = $validatedData['weight_used'];
            }
            if (isset($validatedData['notes'])) {
                $updateData['notes'] = $validatedData['notes'];
            }
            if (isset($validatedData['gps_data'])) {
                $updateData['gps_data'] = json_encode($validatedData['gps_data']);
            }

            DB::table('exercise_program')
                ->where('exercise_id', $exerciseId)
                ->where('program_id', $programId)
                ->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Exercise completed successfully',
                'data' => [
                    'program_id' => $programId,
                    'exercise_id' => $exerciseId,
                    'finished_at' => $finishedAt->toISOString(),
                ],
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Invalid input',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
