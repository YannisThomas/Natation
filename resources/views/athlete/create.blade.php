@extends('layouts.base')
@section('title', 'Ajouter un athlète')
@section('content')

<div class="athlete-creation-section">
    <div class="section-header">
        <h1>Ajouter un nouvel athlète</h1>
        <p class="section-description">Créez un compte pour un nouvel athlète que vous entraînez.</p>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-container">
        <form method="POST" action="{{ route('athlete.store') }}">
            @csrf
            
            <div class="form-group">
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" name="firstname" id="firstname" class="form-control" value="{{ old('firstname') }}" required>
                @error('firstname')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="lastname" class="form-label">Nom</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname') }}" required>
                @error('lastname')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <p class="form-hint">Le mot de passe doit contenir au moins 8 caractères.</p>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                @error('password_confirmation')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <a href="{{ route('program.athletes') }}" class="btn btn-outline">Annuler</a>
                <button type="submit" class="btn btn-primary">Ajouter l'athlète</button>
            </div>
        </form>
    </div>
</div>

<style>
    .athlete-creation-section {
        max-width: 600px;
        margin: 0 auto;
        padding: var(--spacing-lg);
    }
    
    .section-header {
        margin-bottom: var(--spacing-xl);
        text-align: center;
    }
    
    .section-description {
        color: var(--blue-dark);
        margin-top: var(--spacing-sm);
    }
    
    .form-container {
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-md);
        border: var(--border-width-thin) solid var(--blue-very-pale);
    }
    
    .form-group + .form-group {
        margin-top: var(--spacing-lg);
    }
    
    .form-label {
        display: block;
        margin-bottom: var(--spacing-sm);
        font-weight: 500;
        color: var(--blue-dark);
    }
    
    .form-control {
        width: 100%;
        padding: var(--spacing-md);
        border: var(--border-width) solid var(--blue-pale);
        border-radius: var(--border-radius-sm);
        font-family: inherit;
        font-size: 1rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--blue-primary);
        box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.25);
    }
    
    .form-hint {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: var(--spacing-xs);
    }
    
    .form-error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: var(--spacing-xs);
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: var(--spacing-xl);
    }
    
    .btn {
        padding: var(--spacing-sm) var(--spacing-lg);
        border-radius: var(--border-radius-sm);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        display: inline-block;
        text-decoration: none;
        border: none;
    }
    
    .btn-primary {
        background-color: var(--blue-primary);
        color: var(--white);
    }
    
    .btn-primary:hover {
        background-color: var(--blue-dark);
    }
    
    .btn-outline {
        background-color: transparent;
        border: 1px solid var(--blue-primary);
        color: var(--blue-primary);
    }
    
    .btn-outline:hover {
        background-color: var(--blue-very-pale);
    }
</style>
@endsection