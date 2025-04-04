@extends('layouts.base')
@section('title', 'Mes Programmes')
@section('content')

<div class="program-section">
    <div class="program-header">
        <h1>Mes Programmes d'Entraînement</h1>
    </div>

    @if($programs->count() > 0)
        <div class="program-filters">
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">Tous</button>
                <button class="filter-tab" data-filter="active">En cours</button>
                <button class="filter-tab" data-filter="completed">Terminés</button>
            </div>
        </div>

        <div class="program-container">
            @foreach ($programs as $program)
                <div class="program-card {{ ($program->end_date && $program->end_date < date('Y-m-d')) ? 'status-completed' : 'status-active' }}">
                    <div class="program-status-indicator 
                        {{ ($program->end_date && $program->end_date < date('Y-m-d')) ? 'completed' : 'active' }}
                    "></div>
                    <div class="program-info">
                        <h3>{{ $program->name }}</h3>
                        <p class="program-meta">
                            <span class="program-date">{{ $program->start_date }} au {{ $program->end_date }}</span>
                        </p>
                        <p><strong>Coach:</strong> {{ $program->coach->firstname ?? 'N/A' }} {{ $program->coach->lastname ?? '' }}</p>
                        
                        <div class="progress-container">
                            @php
                                $total = $program->exercises->count();
                                $completed = $program->exercises->where('pivot.finished_at', '!=', null)->count();
                                $progressPercent = $total > 0 ? round(($completed / $total) * 100) : 0;
                            @endphp
                            <div class="progress-label">Progression ({{ $progressPercent }}%)</div>
                            <div class="progress-bar">
                                <div class="progress-value" style="width: {{ $progressPercent }}%"></div>
                            </div>
                            <div class="progress-stats">
                                <span>{{ $completed }}/{{ $total }} exercices terminés</span>
                            </div>
                        </div>
                        
                        <div class="program-stats">
                            <div class="stat">
                                <div class="stat-value">{{ $program->exercises->count() }}</div>
                                <div class="stat-label">Exercices</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">
                                    @php
                                        // Calculer le nombre de jours restants
                                        $endDate = new DateTime($program->end_date);
                                        $today = new DateTime();
                                        $daysLeft = $today <= $endDate ? $today->diff($endDate)->days : 0;
                                        echo $daysLeft;
                                    @endphp
                                </div>
                                <div class="stat-label">Jours restants</div>
                            </div>
                        </div>
                    </div>
                    <div class="program-actions">
                        <a href="{{ route('exercise.show', $program->id) }}" class="btn btn-primary">Voir les exercices</a>
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
                <p>Vous n'avez encore aucun programme d'entraînement assigné.</p>
                <p>Contactez votre coach pour qu'il vous crée un programme.</p>
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
    justify-content: center;
}

.filter-tabs {
    display: flex;
    border-radius: var(--border-radius-md);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.filter-tab {
    padding: var(--spacing-sm) var(--spacing-lg);
    background-color: var(--white);
    border: none;
    border-right: var(--border-width) solid var(--blue-very-pale);
    cursor: pointer;
    font-weight: 500;
    color: var(--blue-dark);
    transition: all 0.2s ease;
}

.filter-tab:last-child {
    border-right: none;
}

.filter-tab.active {
    background-color: var(--blue-primary);
    color: var(--white);
}

.filter-tab:hover {
    background-color: var(--blue-very-pale);
    color: var(--blue-dark);
}

.filter-tab.active:hover {
    background-color: var(--blue-secondary);
    color: var(--white);
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

.progress-container {
    margin: var(--spacing-lg) 0;
}

.progress-label {
    margin-bottom: var(--spacing-xs);
    font-weight: 500;
    color: var(--blue-dark);
}

.progress-bar {
    height: 10px;
    background-color: var(--blue-very-pale);
    border-radius: var(--border-radius-sm);
    overflow: hidden;
}

.progress-value {
    height: 100%;
    background: linear-gradient(to right, var(--blue-primary), var(--blue-light));
    border-radius: var(--border-radius-sm);
}

.progress-stats {
    display: flex;
    justify-content: flex-end;
    margin-top: var(--spacing-xs);
    font-size: 0.8rem;
    color: var(--dark-gray);
}

.program-stats {
    display: flex;
    justify-content: space-around;
    margin-top: var(--spacing-lg);
    padding: var(--spacing-md) 0;
    border-top: var(--border-width) dashed var(--blue-very-pale);
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtrage des programmes
    const filterTabs = document.querySelectorAll('.filter-tab');
    const programCards = document.querySelectorAll('.program-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Supprimer la classe active de tous les onglets
            filterTabs.forEach(t => t.classList.remove('active'));
            
            // Ajouter la classe active à l'onglet cliqué
            tab.classList.add('active');
            
            // Récupérer le filtre sélectionné
            const filter = tab.dataset.filter;
            
            // Afficher ou masquer les programmes en fonction du filtre
            programCards.forEach(card => {
                if (filter === 'all' || 
                    (filter === 'active' && card.classList.contains('status-active')) ||
                    (filter === 'completed' && card.classList.contains('status-completed'))) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection