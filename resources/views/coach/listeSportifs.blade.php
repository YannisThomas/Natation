@extends('layouts.auth.auth')
@section('title', 'Mes Sportifs')
@section('content')

<h2>Mes Sportifs</h2>
<link rel="stylesheet" href="{{ asset('css/listeSportifs.css') }}">

<div class="sport-container">
    @if(isset($sportifs) && $sportifs->isEmpty())
        <p class="p_progVide">Aucun sportif ne vous est associé.</p>
    @else
        <ul>
            @foreach ($sportifs as $sportif)
                <li>
                    <a href="{{ route('coach.showAthlete', ['id' => $sportif->id]) }}" class="sport-button">
                        {{ $sportif->firstname }} {{ $sportif->lastname }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

@endsection
