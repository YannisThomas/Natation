<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramApiController;
use App\Http\Controllers\Api\ExerciceApiController;

Route::get('/programme/{programme}/exercice/{exercise}', [App\Http\Controllers\Api\ProgramApiController::class, 'finished']);


Route::post('/post-exercice', [App\Http\Controllers\Api\ExerciceApiController::class, 'postExercice'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
