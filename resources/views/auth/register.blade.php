<x-guest-layout>
    <h1 class="auth-title">Inscription</h1>
    <p class="auth-subtitle">Créez votre compte pour commencer</p>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Prénom -->
        <div class="form-group">
            <label for="firstname" class="form-label">Prénom</label>
            <input id="firstname" class="form-control" type="text" name="firstname" value="{{ old('firstname') }}" required autofocus autocomplete="firstname">
            @error('firstname')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Nom -->
        <div class="form-group">
            <label for="lastname" class="form-label">Nom</label>
            <input id="lastname" class="form-control" type="text" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname">
            @error('lastname')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Rôle -->
        <div class="form-group">
            <label for="role_id" class="form-label">Rôle</label>
            <select id="role_id" name="role_id" class="form-control" required>
                @if($roles->count() > 0)
                    @foreach ($roles as $role)
                        @if($role->name != 'admin') <!-- Ne pas afficher le rôle admin -->
                            <option value="{{ $role->id }}">
                                @if($role->name == 'coach')
                                    Coach
                                @elseif($role->name == 'sportif')
                                    Athlète
                                @else
                                    {{ ucfirst($role->name) }}
                                @endif
                            </option>
                        @endif
                    @endforeach
                @else
                    <option value="">Aucun rôle disponible</option>
                @endif
            </select>
            @error('role_id')
                <div class="form-error">{{ $message }}</div>
            @enderror
            @if($roles->count() == 0)
                <div class="form-error">Problème avec les rôles. Contactez l'administrateur.</div>
            @endif
            <div class="form-hint">Note: Les athlètes ne peuvent pas s'inscrire directement. Demandez à votre coach de vous ajouter.</div>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Photo -->
        <div class="form-group">
            <label for="photo" class="form-label">Photo de profil</label>
            <input id="photo" class="form-control" type="file" name="photo" accept="image/*">
            <div class="form-hint">Optionnel. Une photo de profil sera générée automatiquement si vous n'en fournissez pas.</div>
            @error('photo')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Mot de passe -->
        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
            <div class="form-hint">Le mot de passe doit contenir au moins 8 caractères.</div>
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirmation du mot de passe -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                S'inscrire
            </button>
        </div>
        
        <div class="form-links">
            <p>Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous</a></p>
        </div>
    </form>
</x-guest-layout>
