@extends('layouts.base')
@section('title', 'Aquafit - Gestion d\'entraînements de natation')
@section('content')
<div class="home-container">
    <div class="welcome-banner">
        <h1>Bienvenue sur Aquafit</h1>
        
        @auth
            <h2>Bonjour, {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h2>
            
            <div class="user-info">
                <p>Vous êtes connecté en tant que 
                    @if(Auth::user()->isAdmin())
                        <strong>Administrateur</strong>
                    @elseif(Auth::user()->isCoach())
                        <strong>Coach</strong>
                    @elseif(Auth::user()->isAthlete())
                        <strong>Athlète</strong>
                    @endif
                </p>
            </div>
            
            <div class="quick-links">
                <!-- Liens rapides communs à tous les utilisateurs -->
                <a href="{{ route('exercise.list') }}" class="quick-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 3zm4 8a4 4 0 0 1-8 0V7a4 4 0 1 1 8 0v4zm-4 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                    Voir tous les exercices
                </a>
                <a href="{{ route('program.list') }}" class="quick-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 1.99-2.181h3.982a2 2 0 0 1 1.478.647L8 4.917l1.35-1.27a2 2 0 0 1 1.478-.647z"/>
                    </svg>
                    Voir tous les programmes
                </a>
                
                @if(Auth::user()->isAdmin())
                    <!-- Liens Admin -->
                    <a href="{{ route('program.athletes') }}" class="quick-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                        Voir tous les athlètes
                    </a>
                @endif
                
                @if(Auth::user()->isCoach())
                    <!-- Liens Coach -->
                    <a href="{{ route('program.athletes') }}" class="quick-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                        Voir mes athlètes
                    </a>
                    <a href="{{ route('program.coach') }}" class="quick-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 1.99-2.181h3.982a2 2 0 0 1 1.478.647L8 4.917l1.35-1.27a2 2 0 0 1 1.478-.647z"/>
                        </svg>
                        Voir mes programmes
                    </a>
                    <a href="{{ route('program.create') }}" class="quick-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Créer un programme
                    </a>
                    <a href="{{ route('exercise.create.form') }}" class="quick-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Créer un exercice
                    </a>
                @endif
                
                @if(Auth::user()->isAthlete())
                    <!-- Liens Athlète -->
                    <a href="{{ route('program.athlete') }}" class="quick-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 1.99-2.181h3.982a2 2 0 0 1 1.478.647L8 4.917l1.35-1.27a2 2 0 0 1 1.478-.647z"/>
                        </svg>
                        Voir mes entraînements
                    </a>
                @endif
            </div>
        @else
            <p class="lead-text">La plateforme de gestion d'entraînements de natation pour coaches et athlètes</p>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="auth-button login">Se connecter</a>
                <a href="{{ route('register') }}" class="auth-button register">S'inscrire</a>
            </div>
        @endauth
    </div>
    
    <div class="features">
        <div class="feature-card">
            <h3>Gestion des Programmes</h3>
            <p>Créez et gérez des programmes d'entraînement personnalisés pour vos athlètes.</p>
            <ul>
                <li>Planification intelligente</li>
                <li>Programmes flexibles</li>
                <li>Suivi des performances</li>
            </ul>
        </div>
        <div class="feature-card">
            <h3>Suivi des Exercices</h3>
            <p>Suivez les progrès et les performances des exercices en temps réel.</p>
            <ul>
                <li>Statistiques détaillées</li>
                <li>Graphiques d'évolution</li>
                <li>Rappels automatiques</li>
            </ul>
        </div>
        <div class="feature-card">
            <h3>Collaboration Coach-Athlète</h3>
            <p>Communiquez efficacement entre coaches et athlètes pour optimiser les performances.</p>
            <ul>
                <li>Partage de programmes</li>
                <li>Commentaires en temps réel</li>
                <li>Notifications automatiques</li>
            </ul>
        </div>
    </div>
    
    <div class="statistics">
        <h2>Pourquoi choisir Aquafit?</h2>
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">Utilisateurs actifs</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">1000+</div>
                <div class="stat-label">Programmes créés</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">95%</div>
                <div class="stat-label">Satisfaction client</div>
            </div>
        </div>
    </div>
</div>

<style>
.statistics {
    text-align: center;
    margin-top: var(--spacing-xxl);
    padding: var(--spacing-lg);
    background-color: var(--white);
    border-radius: var(--border-radius-md);
    box-shadow: var(--shadow-md);
    border: var(--border-width) solid var(--blue-very-pale);
}

.statistics h2 {
    margin-bottom: var(--spacing-lg);
    color: var(--blue-primary);
}

.stats-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: var(--spacing-lg);
}

.stat-item {
    flex: 1;
    min-width: 150px;
    padding: var(--spacing-lg);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--blue-primary);
    margin-bottom: var(--spacing-sm);
}

.stat-label {
    font-size: 1rem;
    color: var(--blue-dark);
}

.feature-card ul {
    margin-top: var(--spacing-md);
    list-style-type: none;
    padding-left: 0;
}

.feature-card li {
    position: relative;
    padding-left: 1.5rem;
    margin-bottom: var(--spacing-sm);
}

.feature-card li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--blue-light);
    font-weight: bold;
}
</style>
@endsection