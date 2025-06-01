<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

// API pour validation d'exercices (PUT pour conformité REST) - Protection CSRF désactivée pour AJAX
Route::put('/programme/{programme}/exercice/{exercise}', [App\Http\Controllers\Api\ProgramApiController::class, 'finished'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// API pour soumission d'exercices depuis mobile
Route::post('/post-exercice', [App\Http\Controllers\Api\ExerciceApiController::class, 'postExercice'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// API pour récupérer les informations d'un athlète
Route::get('/athlete/{id}', [\App\Http\Controllers\Api\UserApiController::class, 'getAthleteDetails']);

// API pour récupérer les programmes d'un athlète (interface mobile)
Route::get('/athlete/{id}/programmes', [\App\Http\Controllers\Api\UserApiController::class, 'getAthletePrograms']);

// API pour récupérer les exercices d'un programme (interface mobile)
Route::get('/programme/{id}', [App\Http\Controllers\Api\ProgramApiController::class, 'show']);

// API pour l'enregistrement de performances depuis mobile (annexe 9-1-B)
Route::post('/performance/record', [App\Http\Controllers\Api\ExerciceApiController::class, 'recordPerformance'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
