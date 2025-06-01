<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    /**
     * Récupérer les informations d'un athlète
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function getAthleteDetails($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            // Vérifier que l'utilisateur demandé est un athlète
            if (!$user->role || $user->role->name !== 'sportif') {
                return response()->json(['error' => 'Cet utilisateur n\'est pas un athlète'], 400)
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'GET');
            }

            // Compter les programmes de l'athlète
            $programCount = $user->programs()->count();

            // Récupérer le dernier programme (si existant)
            $lastProgram = $user->programs()->orderBy('end_date', 'desc')->first();

            return response()->json([
                'id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'program_count' => $programCount,
                'last_program' => $lastProgram ? [
                    'name' => $lastProgram->name,
                    'end_date' => $lastProgram->end_date,
                ] : null,
            ])
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            \Log::error('Erreur lors de la récupération des détails de l\'athlète: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des informations de l\'athlète', 
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
        }
    }

    /**
     * @OA\Get(
     *      path="/athlete/{id}/programmes",
     *      operationId="getAthletePrograms",
     *      tags={"Athletes"},
     *      summary="Get athlete programs for mobile interface",
     *      description="Récupère les programmes d'un athlète pour interface mobile (annexe 9-1-B)",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Athlete ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Athlete programs retrieved successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="programs", type="array", @OA\Items(type="object"))
     *          )
     *      )
     * )
     */
    public function getAthletePrograms($id): JsonResponse
    {
        try {
            $athlete = User::with(['programs.exercises.category', 'role'])->findOrFail($id);

            if (!$athlete->role || $athlete->role->name !== 'sportif') {
                return response()->json([
                    'error' => 'User is not an athlete',
                ], 400);
            }

            $programs = $athlete->programs->map(function ($program) {
                $totalExercises = $program->exercises->count();
                $completedExercises = $program->exercises->where('pivot.finished_at', '!=', null)->count();
                
                return [
                    'id' => $program->id,
                    'name' => $program->name,
                    'description' => $program->description,
                    'start_date' => $program->start_date,
                    'end_date' => $program->end_date,
                    'progress' => $totalExercises > 0 ? round(($completedExercises / $totalExercises) * 100) : 0,
                    'total_exercises' => $totalExercises,
                    'completed_exercises' => $completedExercises,
                    'exercises' => $program->exercises->map(function ($exercise) {
                        return [
                            'id' => $exercise->id,
                            'name' => $exercise->name,
                            'description' => $exercise->description,
                            'duration' => $exercise->duration,
                            'distance' => $exercise->distance,
                            'repetition' => $exercise->repetition,
                            'category' => $exercise->category->name ?? 'Non catégorisé',
                            'is_completed' => $exercise->pivot->finished_at !== null,
                            'finished_at' => $exercise->pivot->finished_at,
                            'is_outdoor' => $exercise->category->name === 'Hors Piscine',
                        ];
                    }),
                ];
            });

            return response()->json([
                'athlete_id' => $id,
                'athlete_name' => $athlete->firstname . ' ' . $athlete->lastname,
                'programs' => $programs,
            ])
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Athlete not found',
                'message' => $e->getMessage(),
            ], 404)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
        }
    }
}
