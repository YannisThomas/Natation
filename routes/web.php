<?php

use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/connexion', function () {
    return view('connexion');
});

Route::get('/inscription', function () {
    return view('inscription');
});

Route::get('/acceuil', function () {
    return redirect()->route('home');
});

// Rediriger dashboard vers home pour les utilisateurs connectés
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Test routes (à supprimer en production)
Route::get('/test', function () {
    return view('test');
});

Route::middleware('admin')->group(function () {
    Route::get('/phpinfo', function () {
        phpinfo();
    });
});

// Routes pour tout utilisateur authentifié
Route::middleware('auth')->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes pour les exercices
Route::prefix('exercice')->group(function () {
    // Routes accessibles par tous
    Route::get('/liste', [ExerciseController::class, 'listeExercice'])->middleware('auth')->name('exercise.list');

    // Routes pour les coachs et admins
    Route::middleware(['auth', 'coach'])->group(function () {
        Route::get('/creation', [ExerciseController::class, 'showForm'])->name('exercise.create.form');
        Route::post('/creation', [ExerciseController::class, 'creationExo'])->name('exercise.create.post');
    });
});

// Routes pour les programmes
Route::prefix('programme')->middleware('auth')->group(function () {
    // Visualisation de programmes accessible à tous les utilisateurs authentifiés
    Route::get('/voir', [ProgramController::class, 'showPrograms'])->name('program.list');
    Route::get('/voir/{id}', [ProgramController::class, 'showExercise'])->name('program.show');
    
    // Route pour validation d'exercices via interface web
    Route::post('/valider/{programId}/exercice/{exerciseId}', [ProgramController::class, 'validateExercise'])->name('program.exercise.validate');

    // Routes pour les coachs (et admins)
    Route::middleware('coach')->group(function () {
        Route::get('/creation', [ProgramController::class, 'showForm'])->name('program.create');
        Route::post('/creation', [ProgramController::class, 'createProgram'])->name('program.create.post');
        Route::get('/athletes', [ProgramController::class, 'showAthletes'])->name('program.athletes');
        Route::get('/mes-programmes', [ProgramController::class, 'showCoachPrograms'])->name('program.coach');
        
        // Visualisation des programmes d'un athlète spécifique (pour coach)
        Route::get('/athlete/{id}', [ProgramController::class, 'showAthletePrograms'])->name('program.athlete.view');
    });

    // Routes pour les athlètes (et admins)
    Route::middleware('athlete')->group(function () {
        Route::get('/mes-entrainements', [ProgramController::class, 'showAthletePrograms'])->name('program.athlete');
    });
});

// Routes pour la gestion des athlètes (pour coachs et admins)
Route::prefix('athlete')->middleware(['auth', 'coach'])->group(function () {
    Route::get('/liste', [AthleteController::class, 'index'])->name('athlete.index');
    Route::get('/creation', [AthleteController::class, 'create'])->name('athlete.create');
    Route::post('/creation', [AthleteController::class, 'store'])->name('athlete.store');
});

// Maintenir la compatibilité avec les anciennes routes pour éviter les erreurs
Route::prefix('programmes')->middleware('auth')->group(function () {
    Route::get('/voir', [ProgramController::class, 'showPrograms']);
    Route::get('/voir/{id}', [ProgramController::class, 'showExercise'])->name('exercise.show');
});

// Redirection pour les anciennes routes
Route::redirect('/coach/athletes', '/programme/athletes');
Route::redirect('/coach/programs', '/programme/mes-programmes');
Route::redirect('/athlete/programs', '/programme/mes-entrainements');

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
