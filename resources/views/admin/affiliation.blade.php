@extends('layouts.auth.auth')
@section('title', 'Affilier un Sportif à un Coach')
@section('content')

<link rel="stylesheet" href="{{ asset('css/affiliation.css') }}">

<div class="affiliation-container">
    <h2>Affilier un Sportif à un Coach</h2>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('affiliate.athlete') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="athlete_id">Sportif :</label>
            <select name="athlete_id" id="athlete_id" required>
                <option value=""> Sélectionnez un sportif </option>
                @foreach($athletes as $athlete)
                    <option value="{{ $athlete->id }}">
                        {{ $athlete->firstname }} {{ $athlete->lastname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="coach_id">Coach :</label>
            <select name="coach_id" id="coach_id" required>
                <option value=""> Sélectionnez un coach </option>
                @foreach($coaches as $coach)
                    <option value="{{ $coach->id }}">
                        {{ $coach->firstname }} {{ $coach->lastname }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-submit">
            ✅ Affilier
        </button>
    </form>
</div>

@endsection
