<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExerciceApiController extends Controller
{
    /**
     * @OA\Post(
     *      path="/post-exercice",
     *      operationId="postExercice",
     *      tags={"Exercises"},
     *      summary="Submit an exercise",
     *      description="Endpoint to submit an exercise",
     *      security={
     *          {"api_key_security_example": {}}
     *      },
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="programme_id", type="integer", example=1),
     *              @OA\Property(property="exercise_id", type="integer", example=2),
     *              @OA\Property(property="name", type="string", example="Exercice 1"),
     *              @OA\Property(property="user_id", type="integer", example=1),
     *              @OA\Property(property="gps", type="array", @OA\Items(type="object",
     *                @OA\Property(property="latitude", type="float", example=48.856614),
     *                @OA\Property(property="longitude", type="float", example=2.352222),
     *              )),
     *
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Successful exercise submission",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="success", type="boolean", example=true)
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Bad request",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="error", type="string", example="Invalid input")
     *          )
     *      )
     * )
     */
    public function postExercice(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'programme_id' => 'required|integer|exists:programmes,id',
                'exercise_id' => 'required|integer|exists:exercises,id',
                'name' => 'required|string|max:255',
                'user_id' => 'required|integer|exists:users,id',
                'gps' => 'array',
                'gps.*.latitude' => 'numeric',
                'gps.*.longitude' => 'numeric',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Exercise submitted successfully',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'error' => 'Invalid input',
                'details' => $e->errors(),
            ], 400);
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/performance/record",
     *      operationId="recordPerformance",
     *      tags={"Exercises"},
     *      summary="Record exercise performance from mobile",
     *      description="Enregistrer les performances depuis mobile (annexe 9-1-B)",
     *      security={
     *          {"api_key_security_example": {}}
     *      },
     *
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="athlete_id", type="integer", example=1, description="ID de l'athlète"),
     *              @OA\Property(property="exercise_id", type="integer", example=2, description="ID de l'exercice"),
     *              @OA\Property(property="program_id", type="integer", example=1, description="ID du programme"),
     *              @OA\Property(property="duration", type="integer", example=1800, description="Durée réalisée en secondes"),
     *              @OA\Property(property="distance", type="float", example=2000.5, description="Distance parcourue"),
     *              @OA\Property(property="repetitions", type="integer", example=25, description="Répétitions effectuées"),
     *              @OA\Property(property="weight", type="float", example=75.5, description="Poids utilisé"),
     *              @OA\Property(property="heart_rate", type="integer", example=155, description="Fréquence cardiaque moyenne"),
     *              @OA\Property(property="calories", type="integer", example=320, description="Calories brûlées"),
     *              @OA\Property(property="notes", type="string", example="Exercice hors piscine réalisé", description="Notes de l'athlète"),
     *              @OA\Property(property="gps_data", type="array", @OA\Items(type="object",
     *                @OA\Property(property="latitude", type="float", example=48.856614),
     *                @OA\Property(property="longitude", type="float", example=2.352222),
     *                @OA\Property(property="timestamp", type="string", example="2024-01-01T12:00:00Z"),
     *                @OA\Property(property="speed", type="float", example=12.5, description="Vitesse en km/h")
     *              ), description="Données GPS pour exercices hors piscine")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Performance recorded successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Performance enregistrée avec succès"),
     *              @OA\Property(property="data", type="object")
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
    public function recordPerformance(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'athlete_id' => 'required|integer|exists:users,id',
                'exercise_id' => 'required|integer|exists:exercises,id',
                'program_id' => 'required|integer|exists:programs,id',
                'duration' => 'sometimes|integer|min:0',
                'distance' => 'sometimes|numeric|min:0',
                'repetitions' => 'sometimes|integer|min:0',
                'weight' => 'sometimes|numeric|min:0',
                'heart_rate' => 'sometimes|integer|between:40,220',
                'calories' => 'sometimes|integer|min:0',
                'notes' => 'sometimes|string|max:1000',
                'gps_data' => 'sometimes|array',
                'gps_data.*.latitude' => 'numeric|between:-90,90',
                'gps_data.*.longitude' => 'numeric|between:-180,180',
                'gps_data.*.timestamp' => 'sometimes|date',
                'gps_data.*.speed' => 'sometimes|numeric|min:0',
            ]);

            // Vérifier que l'athlète est bien assigné à ce programme
            $athlete = \App\Models\User::with('role')->findOrFail($validatedData['athlete_id']);
            if ($athlete->role->name !== 'sportif') {
                return response()->json([
                    'error' => 'User is not an athlete',
                ], 400);
            }

            $program = \App\Models\Program::findOrFail($validatedData['program_id']);
            if ($program->user_id !== $validatedData['athlete_id']) {
                return response()->json([
                    'error' => 'Athlete is not assigned to this program',
                ], 403);
            }

            // Vérifier que l'exercice fait partie du programme
            $exerciseInProgram = \Illuminate\Support\Facades\DB::table('exercise_program')
                ->where('exercise_id', $validatedData['exercise_id'])
                ->where('program_id', $validatedData['program_id'])
                ->first();

            if (!$exerciseInProgram) {
                return response()->json([
                    'error' => 'Exercise is not part of this program',
                ], 404);
            }

            // Enregistrer la performance (marquer comme terminé avec données)
            $updateData = [
                'finished_at' => now(),
            ];

            if (isset($validatedData['duration'])) {
                $updateData['duration_completed'] = $validatedData['duration'];
            }
            if (isset($validatedData['distance'])) {
                $updateData['distance_completed'] = $validatedData['distance'];
            }
            if (isset($validatedData['repetitions'])) {
                $updateData['repetitions_completed'] = $validatedData['repetitions'];
            }
            if (isset($validatedData['weight'])) {
                $updateData['weight_used'] = $validatedData['weight'];
            }
            if (isset($validatedData['notes'])) {
                $updateData['notes'] = $validatedData['notes'];
            }

            // Enrichir les données GPS avec métadonnées pour exercices hors piscine
            if (isset($validatedData['gps_data'])) {
                $enrichedGpsData = [
                    'recorded_at' => now()->toISOString(),
                    'device' => 'mobile_app',
                    'heart_rate' => $validatedData['heart_rate'] ?? null,
                    'calories' => $validatedData['calories'] ?? null,
                    'points' => $validatedData['gps_data'],
                ];
                $updateData['gps_data'] = json_encode($enrichedGpsData);
            }

            \Illuminate\Support\Facades\DB::table('exercise_program')
                ->where('exercise_id', $validatedData['exercise_id'])
                ->where('program_id', $validatedData['program_id'])
                ->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Performance enregistrée avec succès depuis l\'interface mobile',
                'data' => [
                    'athlete_id' => $validatedData['athlete_id'],
                    'exercise_id' => $validatedData['exercise_id'],
                    'program_id' => $validatedData['program_id'],
                    'recorded_at' => now()->toISOString(),
                    'is_outdoor_exercise' => isset($validatedData['gps_data']),
                ],
            ], 201);

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
