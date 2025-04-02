<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramApiController;
use App\Http\Controllers\Api\ExerciseApiController;
use App\http\Controllers\Auth\ExerciseController;
//Route:us:get('/programme/{programme}/exercice/{exercice}', [\App\Http\Controllers\Api\ExerciseApiController::class, 'finish']);

Route::get('/extest', [App\http\Controllers\ExerciseController::class, 'showForm']);


//withoutMiddleware([\illuminate\fondation\Htpp\Middleware\VerifyCsrToken::class]);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/post-exercice', [App\Http\Controllers\Api\ExerciseApiController::class, "postExercise"]);
});
