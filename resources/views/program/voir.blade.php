@extends('layouts.base')
@section('title', 'liste des programmes')
@section('content')

    <h2>Listing des programmes</h2>
    <div class="program-container">
        @foreach ($programs as $program)
            Nom : <a href="{{ route('exercise.show', $program->id) }}" class="program-button">{{ $program->name }}</a><br>
        @endforeach
    </div>
@endsection
