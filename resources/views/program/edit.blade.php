@extends('layouts.auth.auth')

@section('title', 'Modifier le programme')

@section('content')
<link rel="stylesheet" href="{{ asset('css/program_edit.css') }}">

<div class="exercise-form-container">
    <h2>Modifier le Programme</h2>

    <form action="{{ route('programs.update', $program->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nom du programme</label>
        <input type="text" name="name" value="{{ $program->titre }}" required>

        <label for="description">Description</label>
        <textarea name="description" required>{{ $program->description }}</textarea>

        <label for="date_debut">Date de début</label>
        <input type="date" name="date_debut" value="{{ $program->date_debut }}" required>

        <label for="date_fin">Date de fin</label>
        <input type="date" name="date_fin" value="{{ $program->date_fin }}" required>

        <button type="submit" class="btn-submit">Enregistrer les modifications</button>
    </form>

    <a href="{{ url()->previous() }}" class="btn btn-secondary" style="margin-top: 20px;">⬅ Retour</a>
</div>
@endsection
