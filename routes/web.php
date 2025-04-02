<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SuperAdminController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/exercice/create', [ExerciseController::class, 'showForm']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/affiliation', [AdminController::class, 'showAffiliationForm'])->name('affiliation');
Route::post('/affiliation', [AdminController::class, 'affiliateAthlete'])->name('affiliate.athlete');
Route::get('/programmes', [ProgramController::class, 'liste'])->name('liste.program');
Route::get('/sportifs', [CoachController::class, 'listeSportifs'])->name('liste.sportifs');
//Route::get('/utilisateurs', [SuperAdminController::class, 'liste'])->name('liste.users');
Route::get('/coach/sportif/{id}', [CoachController::class, 'showAthlete'])->name('coach.showAthlete');

Route::get('/exercice/create', [ExerciseController::class, 'showForm'])->name('exercises.create');
Route::post('/exercice/create', [ExerciseController::class, 'createExo'])->name('exercises.store');
Route::get('/exercices', [ExerciseController::class, 'list'])->name('exercises.list');

Route::get('/programs/create/{sportif_id}', [ProgramController::class, 'create'])->name('programs.create');

// Route pour enregistrer un programme (méthode POST)
Route::post('/programs/create', [ProgramController::class, 'store'])->name('programs.store');
// Route pour éditer un programme
Route::get('/programs/edit/{program_id}', [ProgramController::class, 'edit'])->name('programs.edit');
// Route pour mettre à jour un programme
Route::put('/programs/edit/{program_id}', [ProgramController::class, 'update'])->name('programs.update');
// Route pour supprimer un programme
Route::delete('/programs/destroy/{program_id}', [ProgramController::class, 'destroy'])->name('programs.destroy');

// Route pour afficher le formulaire de création d'un programme
Route::get('/programs/create/{sportif_id}', [ProgramController::class, 'create'])->name('programs.create');
// Route pour enregistrer un programme dans la base de données
Route::post('/programs/store', [ProgramController::class, 'store'])->name('programs.store');
// Route pour afficher les programmes d'un sportif
Route::get('/sportif/{sportif_id}/programs', [ProgramController::class, 'show'])->name('programs.show');


// Route pour afficher la liste des sportifs du coach
Route::get('/coach/sportifs', [CoachController::class, 'listeSportifs'])->name('coach.listeSportifs');

Route::get('/sportif/{id}', [ProgramController::class, 'show'])->name('sportif.show');

// Route pour afficher les programmes du sportif
Route::get('/programs/{sportif_id}', [ProgramController::class, 'show'])->name('programs.show');

// Route pour enregistrer un programme
Route::post('/programs/create', [ProgramController::class, 'store'])->name('programs.store');

// route pour afficher les programme en tant que sportif
Route::get('/mes-programmes', [ProgramController::class, 'mesProgrammes'])->middleware('auth')->name('sportif.programs');

Route::get('/mes-programmes/{id}', [ProgramController::class, 'voirProgramme'])->middleware('auth')->name('sportif.program.show');

// Routes Superadmin (plus de middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [SuperAdminController::class, 'listUsers'])->name('superadmin.users');
    Route::get('/admin/users/create', [SuperAdminController::class, 'createUser'])->name('superadmin.create');
    Route::post('/admin/users', [SuperAdminController::class, 'storeUser'])->name('superadmin.store');
    Route::get('/admin/users/{id}/edit', [SuperAdminController::class, 'editUser'])->name('superadmin.edit');
    Route::put('/admin/users/{id}', [SuperAdminController::class, 'updateUser'])->name('superadmin.update');
    Route::delete('/admin/users/{id}', [SuperAdminController::class, 'deleteUser'])->name('superadmin.delete');
});

