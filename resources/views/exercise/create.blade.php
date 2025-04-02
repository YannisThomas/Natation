@extends('layouts.auth.auth')
@section('title', 'Créer un exercice')
@section('content')

<link rel="stylesheet" href="{{ asset('css/createExercise.css') }}">

<div class="exercise-form-container">
    <h2>📝 Créer un nouvel exercice</h2>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <!-- FORMULAIRE : Ajout du token CSRF -->
    <form action="{{ route('exercises.store') }}" method="POST">
        @csrf  <!-- Cette ligne génère un jeton CSRF -->
        
        <label for="name">Nom *</label>
        <input type="text" name="name" required>

        <label for="description">Description</label>
        <textarea name="description"></textarea>

        <label for="type">Type *</label>
        <input type="text" name="type" required>

        <label for="duration">Durée (secondes)</label>
        <input type="number" name="duration">

        <label for="weight">Poids (kg)</label>
        <input type="number" name="weight">

        <label for="distance">Distance (mètres)</label>
        <input type="number" name="distance">

        <label for="repetition">Répétitions</label>
        <input type="number" name="repetition">

        <button type="submit" class="btn-submit">Créer l'exercice</button>
    </form>
</div>
@endsection
