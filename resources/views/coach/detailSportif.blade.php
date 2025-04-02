@extends('layouts.auth.auth')

@section('title', 'Détail du Sportif')

@section('content')
<!-- Lien vers le CSS -->
<link rel="stylesheet" href="{{ asset('css/detailSportif.css') }}">

<div class="sportif-detail-container">
    <h2>Détails du Sportif</h2>

    <div class="sportif-info">
        <p><strong>Nom :</strong> {{ $sportif->firstname }} {{ $sportif->lastname }}</p>
        <p><strong>Email :</strong> {{ $sportif->email }}</p>
        <p><strong>Créé le :</strong> {{ $sportif->created_at->format('d/m/Y') }}</p>
    </div>

    <hr>

    <h3>Programmes du Sportif</h3>

    <div class="buttons-container">
        <!-- Bouton pour ajouter un programme -->
        <a href="{{ route('programs.create', ['sportif_id' => $sportif->id]) }}" class="btn btn-success">Ajouter un Programme</a>

        <!-- Nouveau bouton pour voir la liste des programmes -->
        <a href="{{ route('programs.show', ['sportif_id' => $sportif->id]) }}" class="btn btn-info">Voir la Liste des Programmes</a>
    </div>

    @if($programs->isEmpty())
        <p>Aucun programme associé à ce sportif.</p>
    @else
        <ul class="program-list">
            @foreach ($programs as $program)
            <li class="program-item">
                <strong>{{ $program->name }}</strong> - {{ $program->description }}
                <br>
                <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-warning">Modifier</a>

                <form action="{{ route('programs.destroy', $program->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce programme ?')">Supprimer</button>
                </form>
            </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('coach.listeSportifs') }}" class="btn btn-primary">Retour à la liste de sportif</a>
</div>

@endsection
