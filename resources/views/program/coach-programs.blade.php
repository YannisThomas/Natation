@extends('layouts.base')
@section('title', 'Mes Programmes')
@section('content')

<div class="program-section">
    <div class="program-header">
        <h1>{{ Auth::user()->isAdmin() ? 'Tous les Programmes' : 'Mes Programmes' }}</h1>
        <a href="{{ route('program.create') }}" class="btn btn-primary">Créer un programme</a>
    </div>

    @if($programs->count() > 0)
        <div class="program-filters">
            <div class="search-box">
                <input type="text" id="program-search" placeholder="Rechercher un programme...">
                <span class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </span>
            </div>
        </div>

        <div class="program-container">
            @foreach ($programs as $program)
                <div class="program-card">
                    <div class="program-status-indicator 
                        {{-- Ajouter une classe basée sur le statut du programme --}}
                        {{ ($program->end_date && $program->end_date < date('Y-m-d')) ? 'completed' : 'active' }}
                    "></div>
                    <div class="program-info">
                        <h3>{{ $program->name }}</h3>
                        <p class="program-meta">
                            <span class="program-date">{{ $program->start_date }} au {{ $program->end_date }}</span>
                        </p>
                        <p><strong>Athlète:</strong> {{ $program->athlete->firstname ?? 'N/A' }} {{ $program->athlete->lastname ?? '' }}</p>
                        @if(Auth::user()->isAdmin())
                            <p><strong>Coach:</strong> {{ $program->coach->firstname ?? 'N/A' }} {{ $program->coach->lastname ?? '' }}</p>
                        @endif
                        <div class="program-stats">
                            <div class="stat">
                                <div class="stat-value">{{ $program->exercises->count() }}</div>
                                <div class="stat-label">Exercices</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">
                                    {{ $program->exercises->where('pivot.finished_at', '!=', null)->count() }}
                                </div>
                                <div class="stat-label">Terminés</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">
                                    @php
                                        $total = $program->exercises->count();
                                        $completed = $program->exercises->where('pivot.finished_at', '!=', null)->count();
                                        echo $total > 0 ? round(($completed / $total) * 100) : 0;
                                    @endphp%
                                </div>
                                <div class="stat-label">Progression</div>
                            </div>
                        </div>
                    </div>
                    <div class="program-actions">
                        <a href="{{ route('exercise.show', $program->id) }}" class="btn btn-primary">Voir le détail</a>
                        <a href="#" class="btn btn-secondary">Modifier</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-programs">
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                </svg>
                <h2>Aucun programme trouvé</h2>
                <p>Vous n'avez pas encore créé de programme d'entraînement.</p>
                <a href="{{ route('program.create') }}" class="btn btn-primary">Créer votre premier programme</a>
            </div>
        </div>
    @endif
</div>

<style>
.program-section {
    max-width: 1200px;
    margin: 0 auto;
}

.program-filters {
    margin-top: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
    display: flex;
    justify-content: flex-end;
}

.search-box {
    position: relative;
    max-width: 300px;
    width: 100%;
}

.search-box input {
    width: 100%;
    padding: var(--spacing-sm) var(--spacing-lg);
    padding-left: 2.5rem;
    border: var(--border-width) solid var(--blue-pale);
    border-radius: var(--border-radius-sm);
    font-family: inherit;
    font-size: 1rem;
}

.search-box input:focus {
    outline: none;
    border-color: var(--blue-primary);
    box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.25);
}

.search-icon {
    position: absolute;
    left: var(--spacing-md);
    top: 50%;
    transform: translateY(-50%);
    color: var(--blue-primary);
}

.program-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: var(--spacing-lg);
}

.program-card {
    background-color: var(--white);
    border-radius: var(--border-radius-md);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: var(--border-width) solid var(--blue-very-pale);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    position: relative;
}

.program-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.program-status-indicator {
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 40px 40px 0;
}

.program-status-indicator.active {
    border-color: transparent var(--blue-primary) transparent transparent;
}

.program-status-indicator.completed {
    border-color: transparent #198754 transparent transparent;
}

.program-info {
    padding: var(--spacing-lg);
}

.program-info h3 {
    color: var(--blue-primary);
    margin-bottom: var(--spacing-sm);
}

.program-meta {
    color: var(--dark-gray);
    font-size: 0.9rem;
    margin-bottom: var(--spacing-md);
}

.program-date {
    display: inline-block;
    padding: var(--spacing-xs) var(--spacing-sm);
    background-color: var(--blue-very-pale);
    border-radius: var(--border-radius-sm);
}

.program-stats {
    display: flex;
    justify-content: space-around;
    margin-top: var(--spacing-lg);
    padding: var(--spacing-md) 0;
    border-top: var(--border-width) dashed var(--blue-very-pale);
    border-bottom: var(--border-width) dashed var(--blue-very-pale);
}

.stat {
    text-align: center;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--blue-primary);
}

.stat-label {
    font-size: 0.8rem;
    color: var(--dark-gray);
}

.program-actions {
    display: flex;
    gap: var(--spacing-sm);
    padding: var(--spacing-md);
    background-color: var(--blue-very-pale);
    border-top: var(--border-width) solid var(--blue-pale);
}

.no-programs {
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