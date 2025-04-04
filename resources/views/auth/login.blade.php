<x-guest-layout>
    <h1 class="auth-title">Connexion</h1>
    <p class="auth-subtitle">Accédez à votre espace d'entraînement</p>
    
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label">Se souvenir de moi</label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Connexion
            </button>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="btn btn-outline">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>
        
        <div class="form-links">
            <p>Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>
        </div>
    </form>
</x-guest-layout>
