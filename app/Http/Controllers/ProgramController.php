<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramRequest;
use App\Models\Exercise;
use App\Models\Program;
use App\Models\User;

class ProgramController extends Controller
{
    /**
     * Affiche les athlètes assignés au coach connecté
     */
    public function showAthletes()
    {
        // Vérifie que l'utilisateur est un coach ou un admin
        if (! auth()->user()->isCoach()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        // Récupère les athlètes du coach connecté (même pour admin)
        $coach = auth()->user();
        $athleteIds = $coach->createdPrograms()->pluck('user_id')->unique();
        $athletes = User::whereIn('id', $athleteIds)->get();

        return view('program.athletes', [
            'athletes' => $athletes,
            'showCreateButton' => true // Ajouter un bouton pour créer un nouvel athlète
        ]);
    }

    /**
     * Affiche les programmes créés par le coach connecté
     */
    public function showCoachPrograms()
    {
        // Vérifie que l'utilisateur est un coach ou un admin
        if (! auth()->user()->isCoach()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        // Récupère uniquement les programmes créés par ce coach (même pour admin)
        $programs = auth()->user()->createdPrograms()->with('athlete')->get();

        return view('program.coach-programs', ['programs' => $programs]);
    }

    /**
     * Affiche les programmes assignés à l'athlète connecté
     */
    public function showAthletePrograms()
    {
        // Vérifie que l'utilisateur est un athlète ou un admin
        if (! auth()->user()->isAthlete()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        // Si c'est un admin, afficher tous les programmes des athlètes
        if (auth()->user()->isAdmin()) {
            $programs = Program::with(['athlete', 'coach'])->get();
        } else {
            // Sinon, récupère les programmes de l'athlète
            $programs = auth()->user()->programs()->with('coach')->get();
        }

        return view('program.athlete-programs', ['programs' => $programs]);
    }

    public function showPrograms()
    {
        // Si utilisateur est admin, montre tous les programmes
        if (auth()->user()->isAdmin()) {
            $programs = Program::with(['athlete', 'coach'])->get();
            return view('program.voir', [
                'programs' => $programs,
                'isAdmin' => true
            ]);
        } 
        // Si c'est un coach, ne montre que les programmes qu'il a créés
        else if (auth()->user()->isCoach()) {
            $programs = auth()->user()->createdPrograms()->with('athlete')->get();
            return view('program.voir', [
                'programs' => $programs,
                'isAdmin' => false
            ]);
        } 
        // Pour les athlètes, ne montre que leurs programmes
        else {
            $programs = auth()->user()->programs;
            return view('program.voir', [
                'programs' => $programs,
                'isAdmin' => false
            ]);
        }
    }

    public function showExercise($programId)
    {
        $program = Program::findOrFail($programId);

        // Vérification des permissions
        $user = auth()->user();

        // Si l'utilisateur n'est pas admin, coach, ou l'athlète concerné, refuse l'accès
        if (! $user->isAdmin() && ! $user->isCoach() && $program->user_id != $user->id) {
            return redirect()->route('program.list')
                ->with('error', 'Vous n\'êtes pas autorisé à accéder à ce programme.');
        }

        $exercises = $program->exercises;

        return view('program.voirprog', ['exercises' => $exercises, 'programs' => $program]);
    }

    public function createProgram(ProgramRequest $request)
    {
        try {
            // Récupère l'ID du coach connecté
            $coachId = auth()->id();

            // Création du programme
            $program = Program::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => $request->user_id, // Athlète
                'coach_id' => $coachId, // Coach qui crée le programme
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            // Attacher les exercices au programme
            $program->exercises()->attach($request->input('exercise_id'));

            // Redirection vers la page du programme créé
            return redirect()->route('program.show', $program->id)
                ->with('success', 'Programme créé avec succès ! Vous pouvez maintenant visualiser et gérer ce programme.');
        } catch (\Exception $e) {
            // En cas d'erreur, retour en arrière avec message d'erreur
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du programme : '.$e->getMessage());
        }
    }

    public function showForm()
    {
        // Si l'utilisateur n'est pas un coach ou un admin, redirigez-le
        if (! auth()->user() || ! auth()->user()->isCoach()) {
            return redirect()->back()->with('error', 'Seuls les coachs et administrateurs peuvent créer des programmes.');
        }

        // Récupérer seulement les utilisateurs avec le rôle "sportif"
        $athletes = User::whereHas('role', function ($query) {
            $query->where('name', 'sportif');
        })->get();

        $exercises = Exercise::all();

        return view('program.create', [
            'users' => $athletes,
            'exercices' => $exercises,
        ]);
    }
}
