@extends('layouts.auth.auth')

@section('title', 'Créer un Programme')

@section('content')
<link rel="stylesheet" href="{{ asset('css/createProgram.css') }}">

<div class="exercise-form-container">
    <h2>Créer un Programme pour {{ $sportif->firstname }} {{ $sportif->lastname }}</h2>

    <form action="{{ route('programs.store') }}" method="POST">
        @csrf
        <input type="hidden" name="sportif_id" value="{{ $sportif->id }}">

        <label for="name">Nom du programme</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label for="description">Description</label>
        <textarea name="description" required>{{ old('description') }}</textarea>

        <label for="date_debut">Date de début</label>
        <input type="date" name="date_debut" value="{{ old('date_debut') }}" required>

        <label for="date_fin">Date de fin</label>
        <input type="date" name="date_fin" value="{{ old('date_fin') }}" required>

        <label for="exercises">Exercices</label>
        <select name="exercises[]" multiple required>
            @foreach ($exercises as $exercise)
                <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn-submit">Créer le programme</button>
    </form>
</div>
@endsection
