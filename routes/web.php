<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/exercice/creation', [App\Http\Controllers\ExerciseController::class, 'showForm']);

Route::post('/exercice/creation', [App\Http\Controllers\ExerciseController::class, 'creationExo']);

Route::get('/programmes/voir', [App\Http\Controllers\ProgramController::class, 'showPrograms']);

Route::get('programmes/voir/{id}', [App\Http\Controllers\ProgramController::class, 'showExercise'])->name('exercise.show');

Route::get('/exercice/liste', [App\Http\Controllers\ExerciseController::class, 'listeExercice']);

Route::get('/phpinfo', function () {
    phpinfo();
});
Route::get('/connexion', function () {
    return view('connexion');
});
Route::get('/inscription', function () {
    return view('inscription');
});

Route::get('/acceuil', function () {
    return view('welcome');
});


Route::post('/programme/creation', [App\Http\Controllers\ProgramController::class, 'createProgram']);
Route::get('/programme/creation', [App\Http\Controllers\ProgramController::class, 'showForm']);

Route::get('/test', function () {
    return view('test');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
