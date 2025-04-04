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
}
