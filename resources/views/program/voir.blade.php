@extends('layouts.base')
@section('title', 'liste des programmes')
@section('content')
    <div class="program-header">
        <h2 class="program-title">Listing des programmes</h2>
        <a href="{{-- route('program.create') --}}" class="program-button">Créer un programme</a>
    </div>

    <div class="program-container">


        @foreach ($programs as $program)
            <div class="program-item">
                Nom : <a href="{{ route('exercise.show', $program->id) }}" class="program-name">{{ $program->name }}</a><br>

                <a href="{{ route('program.create') }}" class="program-button-delete"></a>

            </div>
        @endforeach
    </div>
@endsection
