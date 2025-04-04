<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/programme/{programme}/exercice/{exercise}', [App\Http\Controllers\Api\ProgramApiController::class, 'finished']);

Route::post('/post-exercice', [App\Http\Controllers\Api\ExerciceApiController::class, 'postExercice'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Route pour récupérer les informations d'un athlète - utilisation d'un contrôleur dédié
Route::get('/athlete/{id}', [\App\Http\Controllers\Api\UserApiController::class, 'getAthleteDetails']);
