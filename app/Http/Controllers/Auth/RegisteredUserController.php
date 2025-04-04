<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Récupérer les rôles, et si aucun n'existe, les créer
        $roles = Role::all();
        
        if ($roles->isEmpty()) {
            // Créer les rôles de base s'ils n'existent pas
            Role::firstOrCreate(['name' => 'admin']);
            Role::firstOrCreate(['name' => 'coach']);
            Role::firstOrCreate(['name' => 'sportif']);
            
            // Récupérer à nouveau les rôles
            $roles = Role::all();
        }

        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des données
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Vérifier si un rôle a été sélectionné
        $roleId = $request->role_id;
        if (!$roleId) {
            // Si aucun rôle n'est sélectionné, utiliser le rôle sportif par défaut
            $roleId = Role::where('name', 'sportif')->first()->id ?? null;
            
            // Si toujours pas de rôle, créer le rôle sportif
            if (!$roleId) {
                $role = Role::create(['name' => 'sportif']);
                $roleId = $role->id;
            }
        }
        
        // Traitement de la photo
        $file = $request->file('photo');
        if (is_null($file)) {
            $path = 'uploads/default_user.jpeg';
        } else {
            $path = $file->store('uploads', 'public');
        }
        
        // Création de l'utilisateur
        $user = User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'role_id' => $roleId,
            'email' => $request->email,
            'photo' => $path,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
