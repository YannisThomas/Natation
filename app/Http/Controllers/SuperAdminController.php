<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // Afficher la liste des utilisateurs
    public function listUsers(Request $request)
    {
        if (Auth::user()->role_id !== 1) {
            abort(403, 'Accès réservé au superadmin.');
        }

        $roles = Role::all();

        // Filtrage par rôle si spécifié dans la requête
        if ($request->filled('role')) {
            $users = User::where('role_id', $request->input('role'))->get();
        } else {
            $users = User::all();
        }

        return view('superadmin.users', compact('users', 'roles'));
    }

    

    // Formulaire pour éditer un utilisateur
    public function editUser($id)
    {
        if (Auth::user()->role_id !== 1) {
            abort(403, 'Accès réservé au superadmin.');
        }

        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('superadmin.edit', compact('user', 'roles'));
    }

    // Mettre à jour un utilisateur
    public function updateUser(Request $request, $id)
    {
        if (Auth::user()->role_id !== 1) {
            abort(403, 'Accès réservé au superadmin.');
        }

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('superadmin.users')->with('success', 'Utilisateur mis à jour');
    }

    // Supprimer un utilisateur
    public function deleteUser($id)
    {
        if (Auth::user()->role_id !== 1) {
            abort(403, 'Accès réservé au superadmin.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('superadmin.users')->with('success', 'Utilisateur supprimé');
    }
}
