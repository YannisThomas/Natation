<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AthleteController extends Controller
{
    /**
     * Affiche le formulaire d'ajout d'un athlète
     */
    public function create()
    {
        // Vérifier que l'utilisateur est admin ou coach
        if (!auth()->user()->isAdmin() && !auth()->user()->isCoach()) {
            return redirect()->route('home')->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        }
        
        return view('athlete.create');
    }
    
    /**
     * Enregistre un nouvel athlète
     */
    public function store(Request $request)
    {
        // Vérifier que l'utilisateur est admin ou coach
        if (!auth()->user()->isAdmin() && !auth()->user()->isCoach()) {
            return redirect()->route('home')->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        }
        
        // Validation des données
        $request->validate([
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        // Récupérer le rôle sportif
        $sportifRole = Role::where('name', 'sportif')->first();
        
        // Si le rôle n'existe pas, le créer
        if (!$sportifRole) {
            $sportifRole = Role::create(['name' => 'sportif']);
        }
        
        // Création de l'utilisateur
        $user = User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $sportifRole->id,
            'photo' => 'uploads/default_user.jpeg', // Photo par défaut
        ]);
        
        // Redirection avec message de succès
        return redirect()->route('program.athletes')->with('success', 'Athlète ajouté avec succès.');
    }
    
    /**
     * Liste les athlètes du coach connecté ou tous les athlètes pour un admin
     */
    public function index()
    {
        // Vérifier que l'utilisateur est admin ou coach
        if (!auth()->user()->isAdmin() && !auth()->user()->isCoach()) {
            return redirect()->route('home')->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        }
        
        $user = auth()->user();
        
        // Si c'est un admin, afficher tous les athlètes
        if ($user->isAdmin()) {
            $athletes = User::whereHas('role', function ($query) {
                $query->where('name', 'sportif');
            })->get();
            $isAdmin = true;
        } else {
            // Pour un coach, récupérer uniquement ses athlètes
            $athleteIds = $user->createdPrograms()->pluck('user_id')->unique();
            $athletes = User::whereIn('id', $athleteIds)->get();
            $isAdmin = false;
        }
        
        return view('athlete.index', compact('athletes', 'isAdmin'));
    }
}
