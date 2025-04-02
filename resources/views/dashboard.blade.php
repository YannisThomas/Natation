@extends('layouts.auth.auth')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

@section('content')
    <div class="dashboard-container">
        <h1>Bienvenue sur votre dashboard</h1>

        <!-- Titre avec rôle -->
        <h2>Vous êtes connecté en tant que <strong>{{ Auth::user()->role->name }}</strong></h2>

        <!-- Debug temporaire pour voir la vraie valeur -->
        @php
            use Illuminate\Support\Str;
            $role = Str::lower(trim(Auth::user()->role->name));
        @endphp
        <p style="text-align:center;"><strong>Rôle détecté :</strong> {{ $role }}</p>

        <!-- Infos utilisateur -->
        <div class="user-info">
            <p><strong>Prénom :</strong> {{ Auth::user()->firstname }}</p>
            <p><strong>Nom :</strong> {{ Auth::user()->lastname }}</p>
            <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
            <p><strong>Téléphone :</strong> {{ Auth::user()->phone ?? 'Non renseigné' }}</p>
        </div>

        <!-- Bouton dynamique -->
        <div class="dashboard-actions">
            @if ($role === 'admin')
                <!-- Bouton pour gérer les affiliations -->
                <form action="{{ route('affiliation') }}" method="GET">
                    <button type="submit" class="btn-dashboard">🧩 Gérer les affiliations</button>
                </form>
                <!-- Ajout du bouton pour créer un exercice -->
                <form action="{{ route('exercises.create') }}" method="GET">
                    <button type="submit" class="btn-dashboard">📝 Créer un exercice</button>
                </form>
            @elseif ($role === 'sportif')
            <form action="{{ route('sportif.programs') }}" method="GET">
                <button type="submit" class="btn-dashboard">🏋️ Voir mes programmes</button>
            </form>
            @elseif ($role === 'coach')
                <form action="{{ route('coach.listeSportifs') }}" method="GET">
                    <button type="submit" class="btn-dashboard">🎯 Voir mes sportifs</button>
                </form>
            @elseif ($role === 'super admin')
                <form action="{{ route('superadmin.users') }}" method="GET">
                    <button type="submit" class="btn-dashboard">🛠️ Gérer les utilisateurs</button>
                </form>
            
            @else
                <p style="text-align: center;">❌ Aucune action disponible pour ce rôle.</p>
            @endif
            
            <form action="{{ route('profile.edit') }}" method="GET">
                <button type="submit" class="btn-dashboard">📝 Modifier mes informations</button>
            </form>
        </div>
    </div>
@endsection
