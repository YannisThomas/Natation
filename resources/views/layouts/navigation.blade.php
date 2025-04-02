<header class="header">
    <link href="/css/navigation.css" rel="stylesheet">
    <!-- Logo -->
    
        <img src="/image/logo.svg" alt="logo" class="logo" />
    

    <!-- Boutons Profil et Déconnexion -->
    <span>
        <a href="{{ route('dashboard') }}" class="btnLogin">Profil</a>

        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btnRegister" style="border: none; background: none; padding: 0;">
                <span class="btnRegister">Déconnexion</span>
            </button>
        </form>
    </span>
</header>
