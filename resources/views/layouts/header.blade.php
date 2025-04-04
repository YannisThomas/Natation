<header class="header">
    <div class="container header-container">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/logo.svg') }}" alt="Aquafit" class="logo-img">
            <span class="logo-text">Aquafit</span>
        </a>
        
        <button class="mobile-menu-toggle" aria-label="Menu" id="mobileMenuToggle">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        
        <nav class="nav-links" id="mainNav">
            @auth
                <!-- Navigation pour utilisateurs connectés -->
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Accueil</span>
                </a>
                
                <!-- Menu Exercices -->
                <a href="{{ route('exercise.list') }}" class="nav-link {{ request()->routeIs('exercise.list') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="8 14 12 16 16 14"></polyline>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12" y2="8"></line>
                    </svg>
                    <span>Exercices</span>
                </a>
                
                <!-- Menu Programmes -->
                <a href="{{ route('program.list') }}" class="nav-link {{ request()->routeIs('program.list') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span>Programmes</span>
                </a>
                
                @if(Auth::user()->isAdmin())
                    <!-- Menus Admin -->
                    <a href="{{ route('program.athletes') }}" class="nav-link {{ request()->routeIs('program.athletes') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Tous les Athlètes</span>
                    </a>
                @endif
                
                @if(Auth::user()->isCoach())
                    <!-- Menus Coach -->
                    <a href="{{ route('program.athletes') }}" class="nav-link {{ request()->routeIs('program.athletes') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Mes Athlètes</span>
                    </a>
                    <a href="{{ route('program.coach') }}" class="nav-link {{ request()->routeIs('program.coach') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span>Mes Programmes</span>
                    </a>
                    <a href="{{ route('program.create') }}" class="nav-link {{ request()->routeIs('program.create') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Créer Programme</span>
                    </a>
                    <a href="{{ route('exercise.create.form') }}" class="nav-link {{ request()->routeIs('exercise.create.form') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 20V10"></path>
                            <path d="M12 20V4"></path>
                            <path d="M6 20v-6"></path>
                        </svg>
                        <span>Créer Exercice</span>
                    </a>
                @endif
                
                @if(Auth::user()->isAthlete())
                    <!-- Menus Athlète -->
                    <a href="{{ route('program.athlete') }}" class="nav-link {{ request()->routeIs('program.athlete') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span>Mes Entraînements</span>
                    </a>
                @endif
                
                <div class="user-menu">
                    <button class="user-name">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->firstname, 0, 1)) }}
                        </div>
                        <span class="user-full-name">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.edit') }}" class="dropdown-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Mon Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Navigation pour visiteurs -->
                <div class="auth-buttons-container">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                        S'inscrire
                    </a>
                </div>
            @endauth
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mainNav = document.getElementById('mainNav');
    
    if (mobileMenuToggle && mainNav) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            mobileMenuToggle.classList.toggle('active');
        });
    }
});
</script>

<style>
.header {
    background-color: var(--white);
    box-shadow: var(--shadow-md);
    padding: var(--spacing-md) 0;
    position: sticky;
    top: 0;
    z-index: var(--z-index-sticky);
    border-bottom: var(--border-width-thin) solid var(--blue-very-pale);
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    display: flex;
    align-items: center;
    padding: var(--spacing-xs) 0;
}

.logo-img {
    height: 40px;
    transition: transform var(--transition-normal) var(--transition-ease);
}

.logo:hover .logo-img {
    transform: scale(1.05);
}

.logo-text {
    font-family: var(--font-family-heading);
    font-weight: var(--font-weight-bold);
    font-size: var(--font-size-xl);
    color: var(--blue-primary);
    margin-left: var(--spacing-sm);
    background: linear-gradient(135deg, var(--blue-primary), var(--blue-medium));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: var(--spacing-lg);
}

.nav-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-xs);
    color: var(--blue-dark);
    font-weight: var(--font-weight-medium);
    padding: var(--spacing-sm) var(--spacing-md);
    border-radius: var(--border-radius-md);
    transition: all var(--transition-normal) var(--transition-ease);
    position: relative;
}

.nav-icon {
    width: 18px;
    height: 18px;
}

.nav-link:hover {
    background-color: var(--blue-very-pale);
    color: var(--blue-primary);
    transform: translateY(-2px);
}

.nav-link.active {
    background-color: var(--blue-primary);
    color: var(--white);
}

.nav-link.active:hover {
    background-color: var(--blue-secondary);
    color: var(--white);
}

.user-menu {
    position: relative;
    margin-left: var(--spacing-sm);
}

.user-name {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm) var(--spacing-md);
    background-color: var(--blue-very-pale);
    color: var(--blue-dark);
    border-radius: var(--border-radius-md);
    cursor: pointer;
    font-weight: var(--font-weight-medium);
    transition: all var(--transition-normal) var(--transition-ease);
    border: none;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue-primary), var(--blue-medium));
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: var(--font-weight-bold);
}

.user-name:hover {
    background-color: var(--blue-pale);
    transform: translateY(-2px);
}

.dropdown-icon {
    transition: transform var(--transition-normal) var(--transition-ease);
}

.user-menu:hover .dropdown-icon {
    transform: rotate(180deg);
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 5px);
    background-color: var(--white);
    min-width: 220px;
    border-radius: var(--border-radius-md);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    border: var(--border-width-thin) solid var(--blue-very-pale);
    z-index: var(--z-index-dropdown);
}

.dropdown-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-md) var(--spacing-lg);
    color: var(--blue-dark);
    transition: all var(--transition-normal) var(--transition-ease);
    text-align: left;
    width: 100%;
    border: none;
    background: none;
    cursor: pointer;
    font-weight: var(--font-weight-medium);
    font-size: var(--font-size-base);
}

.dropdown-link:hover {
    background-color: var(--blue-very-pale);
    color: var(--blue-primary);
}

.dropdown-divider {
    height: 1px;
    background-color: var(--blue-very-pale);
    margin: 0;
}

.user-menu:hover .dropdown-menu {
    display: block;
    animation: fadeIn var(--transition-normal) var(--transition-ease);
}

.auth-buttons-container {
    display: flex;
    gap: var(--spacing-md);
}

/* Mobile menu toggle */
.mobile-menu-toggle {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 21px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    z-index: var(--z-index-fixed);
}

.bar {
    width: 100%;
    height: 3px;
    background-color: var(--blue-primary);
    border-radius: 1.5px;
    transition: all var(--transition-normal) var(--transition-ease);
}

.mobile-menu-toggle.active .bar:nth-child(1) {
    transform: translateY(9px) rotate(45deg);
}

.mobile-menu-toggle.active .bar:nth-child(2) {
    opacity: 0;
}

.mobile-menu-toggle.active .bar:nth-child(3) {
    transform: translateY(-9px) rotate(-45deg);
}

/* Responsive */
@media (max-width: 992px) {
    .mobile-menu-toggle {
        display: flex;
    }
    
    .nav-links {
        position: fixed;
        top: 0;
        right: -100%;
        width: 80%;
        max-width: 350px;
        height: 100vh;
        background-color: var(--white);
        flex-direction: column;
        align-items: flex-start;
        padding: 80px var(--spacing-lg) var(--spacing-lg);
        transition: right var(--transition-normal) var(--transition-ease);
        box-shadow: var(--shadow-lg);
        z-index: var(--z-index-fixed);
        overflow-y: auto;
    }
    
    .nav-links.active {
        right: 0;
    }
    
    .nav-link, 
    .user-menu,
    .auth-buttons-container {
        width: 100%;
    }
    
    .user-name {
        width: 100%;
        justify-content: space-between;
    }
    
    .dropdown-menu {
        position: static;
        margin-top: var(--spacing-sm);
        box-shadow: none;
        border: var(--border-width-thin) solid var(--blue-very-pale);
        border-radius: var(--border-radius-sm);
    }
    
    .auth-buttons-container {
        flex-direction: column;
    }
}
</style>