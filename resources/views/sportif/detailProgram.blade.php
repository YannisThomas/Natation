@extends('layouts.auth.auth')

@section('title', 'Détail du Programme')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/sportif_detailprogram.css') }}">

    <div class="program-detail-container">
        <h2>{{ $program->name }}</h2>

        <p><strong>Période :</strong> Du {{ \Carbon\Carbon::parse($program->date_debut)->translatedFormat('d F Y') }}
            au {{ \Carbon\Carbon::parse($program->date_fin)->translatedFormat('d F Y') }}</p>
            

        <hr>

        <h3>📋 Exercices du programme</h3>

        @if ($program->exercises->isEmpty())
            <p>Aucun exercice associé.</p>
        @else
            <ul>
                @foreach ($program->exercises as $exo)
                    <li>
                        <strong>{{ $exo->name }}</strong><br>
                        {{ $exo->description }}<br>
                        🔁 Répétitions : {{ $exo->repetition ?? '-' }}<br>
                        🏋️‍♂️ Poids : {{ $exo->weight ?? '-' }} kg<br>
                        📏 Distance : {{ $exo->distance ?? '-' }} m<br>
                        ⏱️ Durée : {{ $exo->duration ?? '-' }} sec
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('sportif.programs') }}" class="btn-secondary">⬅ Retour</a>
    </div>
@endsection
