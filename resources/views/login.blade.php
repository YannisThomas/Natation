@extends('layouts.base')
@extends('layouts.header')
@section('title', 'aquafit - login')
@section('content')
    <div class="login-register-container">
        <div class="login-register-box">
            <h2>Connexion</h2>
            <form class="login-register-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-register-btn">Se connecter</button>

            </form>
        </div>
    </div>
@endsection
