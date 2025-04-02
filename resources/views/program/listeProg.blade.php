@extends('layouts.base')

@section('title', 'Mes Programmes')

@section('content')
@include('layouts.auth.auth') <!-- si nécessaire -->
<h2>Mes Programmes</h2>
<link rel="stylesheet" href="{{ asset('css/listeProg.css') }}">
<div class="program-container">
    @if($programs->isEmpty())
    <p class="p_progVide">Aucun programme n'est associé à votre compte.</p>
    @else
    <ul>
        @foreach ($programs as $program)
        <li>
            <a href="{{ route('exercise.show', $program->id) }}" class="program-button">
                {{ $program->name }}
            </a>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection
