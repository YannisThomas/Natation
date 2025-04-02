@extends('layouts.auth.auth')

@section('title', 'Programmes de ' . $sportif->firstname)

@section('content')
    <link rel="stylesheet" href="{{ asset('css/program_index.css') }}">

    @php
        use Carbon\Carbon;
    @endphp

    <div class="container">
        <h2>Programmes de {{ $sportif->firstname }} {{ $sportif->lastname }}</h2>

        <!-- 🚀 Bouton pour ajouter un nouveau programme -->
        <div style="text-align: right; margin-bottom: 20px;">
            <a href="{{ route('programs.create', $sportif->id) }}" class="btn btn-success">+ Ajouter un programme</a>
        </div>

        @if($programs->isEmpty())
            <p>Aucun programme pour ce sportif.</p>
        @else
            <ul>
                @foreach($programs as $program)
                    <li>
                        <strong>{{ $program->name }}</strong> - {{ $program->description }}<br>
                        🗓️ Du {{ Carbon::parse($program->date_debut)->translatedFormat('d F Y') }}
                        au {{ Carbon::parse($program->date_fin)->translatedFormat('d F Y') }}
                        <br>

                        <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-warning">Modifier</a>

                        <form action="{{ route('programs.destroy', $program->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Voulez-vous vraiment supprimer ce programme ?')">Supprimer</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
