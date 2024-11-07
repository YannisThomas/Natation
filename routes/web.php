<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/exercice/create', [App\Http\Controllers\ExerciseController::class, 'showForm']);

Route::post('/exercice/create', [App\Http\Controllers\ExerciseController::class, 'createExo']);
