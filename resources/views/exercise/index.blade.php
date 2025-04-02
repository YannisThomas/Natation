@extends('layouts.auth.auth')
@section('title', 'Liste des exercices')
@section('content')

<link rel="stylesheet" href="{{ asset('css/listExercise.css') }}">

<div class="exercise-list-container">
    <h2>📋 Exercices enregistrés</h2>

    @if($exercises->isEmpty())
        <p>Aucun exercice pour l'instant.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Durée</th>
                    <th>Poids</th>
                    <th>Distance</th>
                    <th>Répétitions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exercises as $exercise)
                    <tr>
                        <td>{{ $exercise->name }}</td>
                        <td>{{ $exercise->type }}</td>
                        <td>{{ $exercise->duration ?? '-' }}</td>
                        <td>{{ $exercise->weight ?? '-' }}</td>
                        <td>{{ $exercise->distance ?? '-' }}</td>
                        <td>{{ $exercise->repetition ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
