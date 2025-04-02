@extends('layouts.auth.auth')

@section('title', 'Mes Programmes')
<link rel="stylesheet" href="{{ asset('css/sportif_listeprogram.css') }}">

@section('content')
    <div class="container">
        <h2>📋 Mes Programmes</h2>

        @if ($programs->isEmpty())
            <p>Vous n'avez aucun programme pour le moment.</p>
        @else
            <ul>
                @foreach ($programs as $program)
                <li>
                    <a href="{{ route('sportif.program.show', $program->id) }}" style="text-decoration:none; color:inherit;">
                        <strong>{{ $program->name }}</strong><br>
                        {{ $program->description }}<br>
                        🗓️ Du {{ \Carbon\Carbon::parse($program->date_debut)->translatedFormat('d F Y') }}
                        au {{ \Carbon\Carbon::parse($program->date_fin)->translatedFormat('d F Y') }}

                    </a>
                </li>
                
                @endforeach
            </ul>
        @endif
    </div>
@endsection
