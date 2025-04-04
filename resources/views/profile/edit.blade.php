@extends('layouts.base')
@section('title', 'Mon Profil')
@section('content')

<div class="profile-page">
    <div class="profile-header">
        <h1>Mon Profil</h1>
        <p class="profile-subtitle">Gérez vos informations personnelles et préférences</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="profile-sections">
        <div class="profile-section">
            <div class="profile-section-header">
                <h2>Informations personnelles</h2>
                <p>Mettez à jour vos informations de profil</p>
            </div>
            <div class="profile-section-content">
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstname" class="form-label">Prénom</label>
                            <input type="text" id="firstname" name="firstname" class="form-control" value="{{ old('firstname', $user->firstname) }}" required>
                            @error('firstname')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="lastname" class="form-label">Nom</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" value="{{ old('lastname', $user->lastname) }}" required>
                            @error('lastname')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="photo" class="form-label">Photo de profil</label>
                        <div class="profile-photo-upload">
                            <div class="current-photo">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->firstname }} {{ $user->lastname }}">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="photo-input">
                                <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
                                <div class="form-hint">Laissez vide pour conserver la photo actuelle</div>
                            </div>
                        </div>
                        @error('photo')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="profile-section">
            <div class="profile-section-header">
                <h2>Sécurité</h2>
                <p>Mettez à jour votre mot de passe</p>
            </div>
            <div class="profile-section-content">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    
                    <div class="form-group">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                        @error('current_password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <div class="form-hint">Minimum 8 caractères</div>
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        @error('password_confirmation')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="profile-section danger-zone">
            <div class="profile-section-header">
                <h2>Zone de danger</h2>
                <p>Actions irréversibles pour votre compte</p>
            </div>
            <div class="profile-section-content">
                <form method="post" action="{{ route('profile.destroy') }}" id="delete-account-form">
                    @csrf
                    @method('delete')
                    
                    <div class="danger-zone-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        <div>
                            <h3>Supprimer mon compte</h3>
                            <p>Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_delete" class="form-label">Mot de passe</label>
                        <input type="password" id="password_delete" name="password" class="form-control" placeholder="Entrez votre mot de passe pour confirmer" required>
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">Supprimer mon compte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-page {
        max-width: 800px;
        margin: 0 auto;
        padding: var(--spacing-lg);
    }
    
    .profile-header {
        margin-bottom: var(--spacing-xl);
    }
    
    .profile-header h1 {
        color: var(--blue-dark);
        margin-bottom: var(--spacing-sm);
    }
    
    .profile-subtitle {
        color: var(--dark-gray);
    }
    
    .profile-sections {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xl);
    }
    
    .profile-section {
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: var(--border-width-thin) solid var(--blue-very-pale);
        overflow: hidden;
    }
    
    .profile-section-header {
        background-color: var(--blue-very-pale);
        padding: var(--spacing-lg);
        border-bottom: var(--border-width-thin) solid var(--blue-pale);
    }
    
    .profile-section-header h2 {
        color: var(--blue-dark);
        margin-bottom: var(--spacing-xs);
        font-weight: var(--font-weight-semibold);
    }
    
    .profile-section-header p {
        color: var(--dark-gray);
        font-size: var(--font-size-sm);
    }
    
    .profile-section-content {
        padding: var(--spacing-lg);
    }
    
    .form-row {
        display: flex;
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
    }
    
    .form-row .form-group {
        flex: 1;
    }
    
    .form-group {
        margin-bottom: var(--spacing-lg);
    }
    
    .form-label {
        display: block;
        margin-bottom: var(--spacing-xs);
        font-weight: var(--font-weight-medium);
        color: var(--blue-dark);
    }
    
    .form-control {
        width: 100%;
        padding: var(--spacing-md);
        border: var(--border-width-thin) solid var(--blue-pale);
        border-radius: var(--border-radius-sm);
        font-family: inherit;
        font-size: var(--font-size-base);
        transition: border-color var(--transition-normal) var(--transition-ease);
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--blue-primary);
        box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.25);
    }
    
    .form-hint {
        font-size: var(--font-size-sm);
        color: var(--dark-gray);
        margin-top: var(--spacing-xs);
    }
    
    .form-error {
        color: #dc3545;
        font-size: var(--font-size-sm);
        margin-top: var(--spacing-xs);
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: var(--spacing-lg);
    }
    
    .btn {
        display: inline-block;
        padding: var(--spacing-sm) var(--spacing-lg);
        border-radius: var(--border-radius-sm);
        font-weight: var(--font-weight-medium);
        cursor: pointer;
        text-align: center;
        transition: all var(--transition-normal) var(--transition-ease);
        border: none;
    }
    
    .btn-primary {
        background-color: var(--blue-primary);
        color: var(--white);
    }
    
    .btn-primary:hover, .btn-primary:focus {
        background-color: var(--blue-dark);
    }
    
    .btn-danger {
        background-color: #dc3545;
        color: var(--white);
    }
    
    .btn-danger:hover, .btn-danger:focus {
        background-color: #bd2130;
    }
    
    .danger-zone {
        border-color: #ffcccc;
    }
    
    .danger-zone .profile-section-header {
        background-color: #fff5f5;
        border-color: #ffcccc;
    }
    
    .danger-zone-warning {
        display: flex;
        align-items: flex-start;
        gap: var(--spacing-md);
        padding: var(--spacing-md);
        background-color: #fff5f5;
        border-radius: var(--border-radius-md);
        margin-bottom: var(--spacing-lg);
    }
    
    .danger-zone-warning svg {
        color: #dc3545;
        flex-shrink: 0;
    }
    
    .danger-zone-warning h3 {
        color: #dc3545;
        margin-bottom: var(--spacing-xs);
        font-weight: var(--font-weight-semibold);
    }
    
    .danger-zone-warning p {
        color: var(--dark-gray);
        font-size: var(--font-size-sm);
        margin: 0;
    }
    
    .profile-photo-upload {
        display: flex;
        align-items: center;
        gap: var(--spacing-lg);
    }
    
    .current-photo {
        flex-shrink: 0;
    }
    
    .current-photo img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .avatar-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-secondary));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: var(--font-weight-bold);
    }
    
    .photo-input {
        flex: 1;
    }
    
    /* Responsive styles */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: var(--spacing-md);
        }
        
        .profile-photo-upload {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<script>
    function confirmDelete() {
        if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
            document.getElementById('delete-account-form').submit();
        }
    }
</script>
@endsection
