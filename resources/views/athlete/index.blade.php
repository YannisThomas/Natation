@extends('layouts.base')
@section('title', isset($isAdmin) && $isAdmin ? 'Tous les Athlètes' : 'Mes Athlètes')
@section('content')

<div class="athletes-list-section">
    <div class="section-header">
        <div class="header-left">
            <h1>{{ isset($isAdmin) && $isAdmin ? 'Tous les Athlètes' : 'Mes Athlètes' }}</h1>
            <p class="section-description">
                {{ isset($isAdmin) && $isAdmin ? 'Liste complète des athlètes dans le système' : 'Liste des athlètes que vous entraînez' }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('athlete.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Ajouter un athlète
            </a>
        </div>
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

    <div class="athletes-container">
        @if($athletes->count() > 0)
            <div class="athletes-grid">
                @foreach($athletes as $athlete)
                    <div class="athlete-card">
                        <div class="athlete-card-header">
                            <div class="athlete-avatar">
                                {{ strtoupper(substr($athlete->firstname, 0, 1) . substr($athlete->lastname, 0, 1)) }}
                            </div>
                            <div class="athlete-info">
                                <h3 class="athlete-name">{{ $athlete->firstname }} {{ $athlete->lastname }}</h3>
                                <p class="athlete-email">{{ $athlete->email }}</p>
                            </div>
                        </div>
                        <div class="athlete-card-body">
                            <div class="athlete-stats">
                                <div class="stat">
                                    <span class="stat-value">{{ $athlete->programs()->count() }}</span>
                                    <span class="stat-label">Programmes</span>
                                </div>
                            </div>
                        </div>
                        <div class="athlete-card-footer">
                            <a href="{{ route('program.create') }}?athlete_id={{ $athlete->id }}" class="btn btn-sm btn-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                Nouveau programme
                            </a>
                            <a href="{{ route('program.athlete.view', $athlete->id) }}" class="btn btn-sm btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                Voir les programmes
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-athletes">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                @if(isset($isAdmin) && $isAdmin)
                    <p>Aucun athlète n'a été créé dans le système</p>
                    <a href="{{ route('athlete.create') }}" class="btn btn-primary">Ajouter un nouvel athlète</a>
                @else
                    <p>Vous n'avez pas encore d'athlètes</p>
                    <a href="{{ route('athlete.create') }}" class="btn btn-primary">Ajouter votre premier athlète</a>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
    .athletes-list-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--spacing-lg);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-xl);
    }
    
    .section-description {
        color: var(--blue-dark);
        margin-top: var(--spacing-xs);
    }
    
    .header-actions {
        display: flex;
        gap: var(--spacing-md);
    }
    
    .btn {
        padding: var(--spacing-sm) var(--spacing-lg);
        border-radius: var(--border-radius-sm);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        text-decoration: none;
        border: none;
    }
    
    .btn-sm {
        padding: var(--spacing-xs) var(--spacing-md);
        font-size: 0.875rem;
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
    
    .athletes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: var(--spacing-lg);
    }
    
    .athlete-card {
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        border: var(--border-width-thin) solid var(--blue-very-pale);
        display: flex;
        flex-direction: column;
    }
    
    .athlete-card-header {
        display: flex;
        align-items: center;
        margin-bottom: var(--spacing-md);
    }
    
    .athlete-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-light));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 600;
        margin-right: var(--spacing-md);
    }
    
    .athlete-name {
        margin: 0;
        font-size: 1.1rem;
        color: var(--blue-dark);
    }
    
    .athlete-email {
        margin: var(--spacing-xxs) 0 0;
        font-size: 0.85rem;
        color: var(--dark-gray);
    }
    
    .athlete-card-body {
        flex: 1;
        margin-bottom: var(--spacing-md);
    }
    
    .athlete-stats {
        display: flex;
        gap: var(--spacing-md);
    }
    
    .stat {
        background-color: var(--blue-very-pale);
        padding: var(--spacing-sm) var(--spacing-md);
        border-radius: var(--border-radius-sm);
        text-align: center;
        flex: 1;
    }
    
    .stat-value {
        font-weight: var(--font-weight-bold);
        font-size: 1.5rem;
        color: var(--blue-primary);
        display: block;
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: var(--blue-dark);
    }
    
    .athlete-card-footer {
        display: flex;
        justify-content: space-between;
        margin-top: auto;
    }
    
    .no-athletes {
        text-align: center;
        padding: var(--spacing-xl);
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: var(--border-width-thin) solid var(--blue-very-pale);
    }
    
    .no-athletes svg {
        color: var(--blue-primary);
        opacity: 0.7;
        margin-bottom: var(--spacing-lg);
    }
    
    .no-athletes p {
        font-size: 1.1rem;
        color: var(--blue-dark);
        margin-bottom: var(--spacing-lg);
    }
    
    @media (max-width: 768px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-actions {
            margin-top: var(--spacing-md);
            align-self: stretch;
        }
        
        .btn {
            flex: 1;
            justify-content: center;
        }
        
        .athletes-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection