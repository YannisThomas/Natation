<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Program;

class CoachController extends Controller
{
    // Affiche la liste des sportifs associés au coach
    public function listeSportifs()
    {
        // Vérifie que l'utilisateur connecté est bien un coach
        $coach = Auth::user();

        // Récupère les sportifs qui ont ce coach comme référent
        $sportifs = $coach->sportifs;

        return view('coach.listeSportifs', compact('sportifs'));
    }

    // Affiche les détails d’un sportif et ses programmes
    public function showAthlete($id)
    {
        $sportif = User::findOrFail($id);

        // Vérifier si le sportif est bien associé au coach connecté
        if ($sportif->coach_id !== Auth::id()) {
            abort(403, 'Vous n\'avez pas accès à ce sportif.');
        }

        $programs = Program::where('sportif_id', $sportif->id)
            ->where('coach_id', Auth::id()) // Seuls les programmes créés par ce coach
            ->get();

        return view('coach.detailSportif', compact('sportif', 'programs'));
    }
}
