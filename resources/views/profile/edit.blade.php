@extends('layouts.auth.auth')

@section('title', 'Mon Profil')

@section('content')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">

<div class="profile-container">
    <h2>👤 Mon Profil</h2>

    {{-- Modifier les infos (email, téléphone) --}}
    <div class="profile-card">
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Changer le mot de passe --}}
    <div class="profile-card">
        @include('profile.partials.update-password-form')
    </div>

    
</div>
@endsection
