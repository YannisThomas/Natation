@extends('layouts.base')
@section('title', 'Creation de Programme')
@section('content')


    <div>
        <h1>Creation de Programme</h1>


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <form method="POST" action="/programme/creation" class="max-w-sm mx-auto">
            @csrf
            <div class="program-item">
                <label for="name">Nom du programme</label>
                <input type="text" name="name" id="name" placeholder="Nom du programme">
            </div>
            <div class="program-item">
                <label for="user_id">Nom de l'athlete</label>
                <select name="user_id" id="user_id">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->lastname }}</option>
                    @endforeach
                </select>
            </div>


            </select>

            <div class="program-item">
                <label for="exercise_id">Nom du ou des
                    exercices</label>
                <select name="exercise_id[]"multiple>
                    @foreach ($exercices as $exercice)
                        <option value="{{ $exercice->id }}">{{ $exercice->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="program-item">
                <label for="start_date">Date de début</label>
                <input type="date" name="start_date" id="start_date">
            </div>
            <div class="program-item">
                <label for="end_date">Date de fin</label>
                <input type="date" name="end_date" id="end_date">
            </div>

    </div>



    </div>

    <button type="submit">Créer Le programme</button>
    </form>
@endsection
