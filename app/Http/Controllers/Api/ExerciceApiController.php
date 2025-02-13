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
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
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
     *      @OA\Response(
     *          response=201,
     *          description="Successful exercise submission",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true)
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Bad request",
     *          @OA\JsonContent(
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
                'gps.*.longitude' => 'numeric'
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Exercise submitted successfully'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'error' => 'Invalid input',
                'details' => $e->errors()
            ], 400);
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
