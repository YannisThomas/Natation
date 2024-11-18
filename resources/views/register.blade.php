@extends('layouts.base')
@extends('layouts.header')
@section('title', 'aquafit - login')
@section('content')
    <div class="login-register-container">
        <div class="login-register-box">
            <h2>Inscription</h2>
            <form id="login-register-form">
                <div class="form-group">
                    <label for="firstname">Prénom:</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Nom:</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>

                <div class="form-group">
                    <label for="birthdate">Date de naissance:</label>
                    <input type="date" id="birthdate" name="birthdate" required pattern="\d{2}-\d{2}-\d{4}"
                        placeholder="DD-MM-YYYY">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Numéro de téléphone:</label>
                    <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}"
                        placeholder="Enter your phone number">
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" required minlength="8">
                </div>

                <button type="submit" class="login-register-button">S'inscrire</button>
            </form>
        </div>
    </div>
@endsection
