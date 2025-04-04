@extends('layouts.base')
@section('title', 'Mes Athlètes')
@section('content')

<div class="athlete-section">
    <div class="athlete-header">
        <div class="header-left">
            <h1>{{ Auth::user()->isAdmin() ? 'Tous les Athlètes' : 'Mes Athlètes' }}</h1>
            <p class="section-description">
                {{ Auth::user()->isAdmin() ? 'Liste de tous les athlètes dans le système.' : 'Liste des athlètes que vous entraînez.' }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('athlete.create') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                    <line x1="12" y1="11" x2="12" y2="17"></line>
                    <line x1="9" y1="14" x2="15" y2="14"></line>
                </svg>
                Ajouter un athlète
            </a>
            <a href="{{ route('program.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Créer un programme
            </a>
        </div>
    </div>

    @if($athletes->count() > 0)
        <div class="athlete-container">
            @foreach ($athletes as $athlete)
                <div class="athlete-card">
                    <div class="athlete-avatar">
                        <div class="avatar-placeholder">
                            {{ strtoupper(substr($athlete->firstname, 0, 1) . substr($athlete->lastname, 0, 1)) }}
                        </div>
                    </div>
                    <div class="athlete-info">
                        <h3>{{ $athlete->firstname }} {{ $athlete->lastname }}</h3>
                        <p><strong>Email:</strong> {{ $athlete->email }}</p>
                        @if($athlete->birthday)
                            <p><strong>Date de naissance:</strong> {{ $athlete->birthday }}</p>
                        @endif
                        @if($athlete->phone)
                            <p><strong>Téléphone:</strong> {{ $athlete->phone }}</p>
                        @endif
                    </div>
                    <div class="athlete-actions">
                        <a href="{{ route('program.create') }}" class="btn btn-primary">Créer un programme</a>
                        
                        <!-- Bouton pour voir les programmes de l'athlète -->
                        <a href="#" class="btn btn-secondary">Voir programmes</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-athletes">
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                </svg>
                <h2>Aucun athlète trouvé</h2>
                <p>Vous n'avez pas encore d'athlètes assignés à vos programmes.</p>
                <a href="{{ route('program.create') }}" class="btn btn-primary">Créer un programme pour un athlète</a>
            </div>
        </div>
    @endif
</div>

<style>
.athlete-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: var(--spacing-md);
}

.athlete-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--spacing-xl);
    flex-wrap: wrap;
    gap: var(--spacing-lg);
}

.header-left h1 {
    margin-bottom: var(--spacing-sm);
    color: var(--blue-dark);
}

.section-description {
    color: var(--dark-gray);
}

.header-actions {
    display: flex;
    gap: var(--spacing-md);
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-xs);
    padding: var(--spacing-sm) var(--spacing-lg);
    border-radius: var(--border-radius-md);
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-primary {
    background-color: var(--blue-primary);
    color: var(--white);
    border: none;
}

.btn-primary:hover {
    background-color: var(--blue-dark);
}

.btn-secondary {
    background-color: var(--white);
    color: var(--blue-primary);
    border: 1px solid var(--blue-primary);
}

.btn-secondary:hover {
    background-color: var(--blue-very-pale);
}

.athlete-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: var(--spacing-lg);
    margin-top: var(--spacing-lg);
}

.athlete-card {
    background-color: var(--white);
    border-radius: var(--border-radius-md);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: var(--border-width) solid var(--blue-very-pale);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
}

.athlete-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.athlete-avatar {
    display: flex;
    justify-content: center;
    padding: var(--spacing-lg) var(--spacing-lg) var(--spacing-sm);
}

.avatar-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue-primary), var(--blue-light));
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 600;
}

.athlete-info {
    padding: 0 var(--spacing-lg) var(--spacing-lg);
    flex-grow: 1;
}

.athlete-info h3 {
    color: var(--blue-primary);
    margin-bottom: var(--spacing-md);
    text-align: center;
}

.athlete-info p {
    margin-bottom: var(--spacing-sm);
    color: var(--dark-gray);
}

.athlete-actions {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-sm);
    padding: var(--spacing-md);
    background-color: var(--blue-very-pale);
    border-top: var(--border-width) solid var(--blue-pale);
    justify-content: center;
}

.no-athletes {
    margin-top: var(--spacing-xl);
}

.empty-state {
    background-color: var(--white);
    border-radius: var(--border-radius-md);
    padding: var(--spacing-xl);
    text-align: center;
    box-shadow: var(--shadow-md);
    border: var(--border-width) solid var(--blue-very-pale);
}

.empty-state svg {
    color: var(--blue-primary);
    margin-bottom: var(--spacing-md);
}

.empty-state h2 {
    margin-bottom: var(--spacing-md);
    color: var(--blue-dark);
}

.empty-state p {
    margin-bottom: var(--spacing-lg);
    color: var(--dark-gray);
}
</style>
@endsection