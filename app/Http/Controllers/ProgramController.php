<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\User;  // Pour récupérer les utilisateurs (sportif, coach)
use App\Models\Exercise; // Importer le modèle Exercise

class ProgramController extends Controller
{
    // Affiche le formulaire de création d'un programme
    public function create($sportif_id)
    {
        // Récupère les informations du sportif
        $sportif = User::findOrFail($sportif_id);

        // Récupère tous les exercices
        $exercises = Exercise::all(); // Récupère tous les exercices existants

        // Passe le sportif et les exercices à la vue
        return view('program.create', compact('sportif', 'exercises'));
    }

    // Enregistre un programme dans la base de données
    public function store(Request $request)
{
    // Validation des champs du formulaire
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'exercises' => 'required|array',
        'exercises.*' => 'exists:exercise,id', // Vérifier que les exercices existent dans la table
    ]);

    // Vérifier que la date de fin n'est pas avant la date de début
    if ($request->date_fin < $request->date_debut) {
        return back()->withErrors(['date_fin' => 'La date de fin doit être après la date de début.']);
    }

    // Création du programme
    $program = Program::create([
        'titre' => $request->name,
        'description' => $request->description,
        'date_debut' => $request->date_debut,
        'date_fin' => $request->date_fin,
        'sportif_id' => $request->sportif_id,
        'coach_id' => auth()->id(),  // Associe le programme au coach connecté
    ]);

    // Lier les exercices sélectionnés au programme via la table pivot
    $program->exercises()->attach($request->exercises);

    // Redirection avec message de succès
    return redirect()->route('sportif.show', ['id' => $request->sportif_id])
                     ->with('success', 'Programme créé avec succès ✅');
}


    // Affiche la liste des programmes d'un sportif
    
    public function show($sportif_id)
{
    // Trouve le sportif par son ID
    $sportif = User::findOrFail($sportif_id);

    // Récupère les programmes associés à ce sportif
    $programs = $sportif->programs; // Cela récupère les programmes associés au sportif

    // Si aucun programme n'existe, retourner un tableau vide
    if ($programs->isEmpty()) {
        $programs = collect();  // Crée une collection vide si aucun programme n'existe
    }

    // Retourne la vue avec les programmes du sportif
    return view('program.index', compact('programs', 'sportif'));
}
public function edit($id)
{
    $program = Program::findOrFail($id);
    return view('program.edit', compact('program'));
}

public function update(Request $request, $id)
{
    // Valider les données
    $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
    ]);

    // Récupérer le programme
    $program = Program::findOrFail($id);

    // Mettre à jour les champs
    $program->update([
        'titre' => $request->name,
        'description' => $request->description,
        'date_debut' => $request->date_debut,
        'date_fin' => $request->date_fin,
    ]);
    

    // Rediriger avec un message de succès
    return redirect()->route('sportif.show', $program->sportif_id)
                     ->with('success', 'Programme mis à jour avec succès ✅');
}
public function destroy($id)
{
    $program = Program::findOrFail($id);
    $sportifId = $program->sportif_id;

    // Supprime les liaisons avec les exercices si tu as une relation pivot
    $program->exercises()->detach();

    // Supprimer le programme
    $program->delete();

    // Redirection avec message
    return redirect()->route('sportif.show', $sportifId)
                     ->with('success', 'Programme supprimé avec succès 🗑️');
}

public function mesProgrammes()
{
    $user = auth()->user();

    // Vérifie que l'utilisateur est bien un sportif
    if ($user->role->name !== 'Sportif') {
        abort(403, 'Accès réservé aux sportifs.');
    }

    // Récupère les programmes associés à ce sportif
    $programs = $user->programs ?? [];

    return view('sportif.ListeProgram', compact('programs'));
}

public function voirProgramme($id)
{
    $user = auth()->user();

    $program = Program::with('exercises')->where('sportif_id', $user->id)->findOrFail($id);

    return view('sportif.DetailProgram', compact('program'));
}



}
