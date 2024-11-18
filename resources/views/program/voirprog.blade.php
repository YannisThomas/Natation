@extends('layouts.base')
@section('title', 'exo pour programme')

@section('content')

    <div class="exercice-container">
        <h1 class="nomprog">Programme {{ $programs->name }}</h1>
        <h2 class="infoprog">date de début {{ $programs->start_date }}</h2>
        <h2 class="infoprog">date de fin {{ $programs->end_date }}</h2>
        @foreach ($programs->exercises as $exercise)
            <div class="program-detail">
                <p class="program-info"><strong>Nom :</strong> {{ $exercise->name }}</p>
                <p class="program-info"><strong>Categorie :</strong> {{ $exercise->category_id }}</p>
                <p class="program-info"><strong>Description :</strong> {{ $exercise->description }}</p>
                <p class="program-info"><strong>Durée :</strong> {{ $exercise->duration }} minutes</p>
                <p class="program-info"><strong>Répétition :</strong> {{ $exercise->repetition }}</p>
                <p class="program-info"><strong>Poids :</strong> {{ $exercise->weight }} Kg</p>
            </div>
        @endforeach

        <a href="{{ url('/programmes/voir') }}" class="program-button">Retour à la liste</a>

    </div>

@endsection
