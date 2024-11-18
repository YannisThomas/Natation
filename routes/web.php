<?php

use App\Models\Exercise;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/exercice/creation', [App\Http\Controllers\ExerciseController::class, 'showForm']);

Route::post('/exercice/creation', [App\Http\Controllers\ExerciseController::class, 'creationExo']);

Route::get('/programmes/voir', [App\Http\Controllers\ProgramController::class, 'showPrograms']);

Route::get('programmes/voir/{id}', [App\Http\Controllers\ProgramController::class, 'showExercise'])->name('exercise.show');

Route::get('/exercice/liste', [App\Http\Controllers\ExerciseController::class, 'listeExercice']);

Route::get('/phpinfo', function () {
    phpinfo();
});
