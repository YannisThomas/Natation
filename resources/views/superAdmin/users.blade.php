@extends('layouts.auth.auth')

@section('title', 'Gestion des utilisateurs')

@section('content')
<link href="{{ asset('css/superAdmin_users.css') }}" rel="stylesheet">

    <div class="container">
        <h2>Liste des utilisateurs</h2>

        <!-- Filtre par rôle -->
        <form method="GET" action="{{ route('superadmin.users') }}" style="margin-bottom: 20px;">
            <select name="role" onchange="this.form.submit()">
                <option value="">FILTRE</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Liste des utilisateurs -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->firstname }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <!-- Modifier un utilisateur -->
                            <a href="{{ route('superadmin.edit', $user->id) }}" class="btn btn-warning">Modifier</a>

                            <!-- Supprimer un utilisateur -->
                            <form action="{{ route('superadmin.delete', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
