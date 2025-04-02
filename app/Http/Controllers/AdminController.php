<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Affiche le formulaire d'affiliation.
     * Seuls les utilisateurs avec role_id 1 (superadmin) ou 2 (admin) ont accès.
     */
    public function showAffiliationForm()
    {
        $user = Auth::user();
        if (!in_array($user->role_id, [1, 2])) {
            abort(403, 'Accès non autorisé.');
        }

        // Récupérer la liste des sportifs (role_id 4) et des coachs (role_id 3)
        $athletes = User::where('role_id', 4)->get();
        $coaches  = User::where('role_id', 3)->get();

        return view('admin.affiliation', compact('athletes', 'coaches'));
    }

    public function affiliateAthlete(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role_id, [1, 2])) {
            abort(403, 'Accès non autorisé.');
        }

        $data = $request->validate([
            'athlete_id' => 'required|exists:users,id',
            'coach_id'   => 'required|exists:users,id',
        ]);

        // On suppose que le sportif possède une colonne coach_id dans la table 'users'
        $athlete = User::findOrFail($data['athlete_id']);
        $athlete->coach_id = $data['coach_id'];
        $athlete->save();

        return redirect()->back()->with('success', 'Sportif affilié avec succès !');
    }
}
