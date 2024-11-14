@extends('layouts.base')
@section('title', 'liste des programmes')
@section('content')

    <h2>Listing des Exercices</h2>
    @foreach ($exercises as $exercise)
        <div class="exercice-container">
            <p> Nom : {{ $exercise->name }}<br></p>
            <p> Durée : {{ $exercise->duration }}</p>
            <p> Type : {{ $exercise->type }}</p>
            <p> Distance : {{ $exercise->distance }}</p>
            <p> Poids : {{ $exercise->weight }}</p>
            <p> Répétition : {{ $exercise->repetition }}</p>
            <p> Description : {{ $exercise->description }}</p>
        </div>
    @endforeach

@endsection
