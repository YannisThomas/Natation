@extends('layouts.base')
@extends('layouts.header')
@section('title', 'aquafit - le-site-des-sportifs')
@section('content')
    <div class="welcome-container">
        <h1>Bienvenue sur Aquafit</h1>
    </div>

    <style>
        .welcome-container {
            position: flex;
            background-image: url("{{ asset('images/Swim.svg') }}");
            background-size: cover;
            background-position-y: -10rem;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;

        }

        .welcome-container h1 {
            color: #000;
            position: fixed;
            top: 15%;
        }
    </style>
@endsection
