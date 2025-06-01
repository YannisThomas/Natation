@extends('layouts.base')
@section('title', 'Liste des programmes')
@section('content')
<div class="programs-section">
    <div class="programs-header">
        <div class="section-title">
            <h1>{{ isset($isAdmin) && $isAdmin ? 'Tous les programmes d\'entraînement' : 'Programmes d\'entraînement' }}</h1>
            <p class="section-description">
                @if(isset($isAdmin) && $isAdmin)
                    Vue administrative de tous les programmes dans le système.
                @elseif(Auth::user()->isCoach())
                    Consultez les programmes que vous avez créés pour vos athlètes.
                @else
                    Consultez vos programmes d'entraînement et suivez votre progression.
                @endif
            </p>
        </div>
        
        @if(Auth::check() && Auth::user()->isCoach())
            <div class="actions">
                <a href="{{ route('program.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Créer un programme
                </a>
            </div>
        @endif
    </div>

    @if($programs->count() > 0)
        <div class="program-filters">
            <div class="search-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" class="search-icon">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" id="program-search" placeholder="Rechercher un programme..." class="search-input">
            </div>
            
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">Tous</button>
                <button class="filter-tab" data-filter="active">En cours</button>
                <button class="filter-tab" data-filter="completed">Terminés</button>
            </div>
        </div>
        
        <div class="programs-grid" id="programs-container">
            @foreach ($programs as $program)
                @php
                    $isCompleted = false;
                    $isActive = true;
                    
                    if ($program->end_date) {
                        $endDate = new DateTime($program->end_date);
                        $today = new DateTime();
                        $isCompleted = $today > $endDate;
                        $isActive = !$isCompleted;
                    }
                @endphp
                
                <div class="program-card {{ $isCompleted ? 'status-completed' : 'status-active' }}">
                    <div class="program-status-indicator {{ $isCompleted ? 'completed' : 'active' }}"></div>
                    
                    <div class="program-content">
                        <div class="program-header">
                            <h3>{{ $program->name }}</h3>
                            <div class="program-meta">
                                <span class="program-dates">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($program->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($program->end_date)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="program-info">
                            @if(isset($program->athlete) && isset($program->coach))
                                <div class="program-participants">
                                    <div class="participant">
                                        <div class="participant-label">Athlète</div>
                                        <div class="participant-name">{{ $program->athlete->firstname }} {{ $program->athlete->lastname }}</div>
                                    </div>
                                    <div class="participant">
                                        <div class="participant-label">Coach</div>
                                        <div class="participant-name">{{ $program->coach->firstname }} {{ $program->coach->lastname }}</div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="program-stats">
                                <div class="stat">
                                    <div class="stat-value">{{ $program->exercises->count() }}</div>
                                    <div class="stat-label">Exercices</div>
                                </div>
                                
                                @php
                                    $completed = $program->exercises->where('pivot.finished_at', '!=', null)->count();
                                    $progress = $program->exercises->count() > 0 ? round(($completed / $program->exercises->count()) * 100) : 0;
                                @endphp
                                
                                <div class="stat">
                                    <div class="stat-value">{{ $progress }}%</div>
                                    <div class="stat-label">Progression</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="program-actions">
                            <a href="{{ route('program.show', $program->id) }}" class="btn btn-primary">Voir les exercices</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path d="M9 17H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-4"></path>
                <path d="M9 21h6"></path>
                <path d="M12 17v4"></path>
            </svg>
            <h2>Aucun programme disponible</h2>
            <p>Il n'y a actuellement aucun programme à afficher.</p>
            
            @if(Auth::check() && Auth::user()->isCoach())
                <a href="{{ route('program.create') }}" class="btn btn-primary">Créer un programme</a>
            @endif
        </div>
    @endif
</div>

<style>
    .programs-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--spacing-md);
    }
    
    .programs-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: var(--spacing-xl);
        flex-wrap: wrap;
        gap: var(--spacing-lg);
    }
    
    .section-title h1 {
        font-size: var(--font-size-2xl);
        color: var(--blue-dark);
        margin-bottom: var(--spacing-sm);
    }
    
    .section-description {
        color: var(--dark-gray);
        max-width: 600px;
    }
    
    .program-filters {
        display: flex;
        justify-content: space-between;
        margin-bottom: var(--spacing-xl);
        flex-wrap: wrap;
        gap: var(--spacing-lg);
    }
    
    .search-box {
        position: relative;
        flex-grow: 1;
        max-width: 350px;
    }
    
    .search-input {
        width: 100%;
        padding: var(--spacing-sm) var(--spacing-md);
        padding-left: 2.5rem;
        border: var(--border-width) solid var(--blue-pale);
        border-radius: var(--border-radius-md);
        transition: all var(--transition-normal) var(--transition-ease);
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--blue-primary);
        box-shadow: var(--shadow-outline);
    }
    
    .search-icon {
        position: absolute;
        left: var(--spacing-md);
        top: 50%;
        transform: translateY(-50%);
        color: var(--blue-primary);
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
    
    .programs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: var(--spacing-lg);
    }
    
    .program-card {
        background-color: var(--white);
        border-radius: var(--border-radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        border: var(--border-width) solid var(--blue-very-pale);
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
    
    .program-content {
        padding: var(--spacing-lg);
    }
    
    .program-header {
        margin-bottom: var(--spacing-lg);
    }
    
    .program-header h3 {
        font-size: var(--font-size-lg);
        color: var(--blue-primary);
        margin-bottom: var(--spacing-sm);
    }
    
    .program-meta {
        display: flex;
        flex-wrap: wrap;
        gap: var(--spacing-sm);
        color: var(--dark-gray);
        font-size: var(--font-size-sm);
    }
    
    .program-dates {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
    }
    
    .program-participants {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        padding-bottom: var(--spacing-md);
        border-bottom: var(--border-width-thin) dashed var(--blue-very-pale);
    }
    
    .participant-label {
        font-size: var(--font-size-xs);
        color: var(--dark-gray);
        margin-bottom: var(--spacing-xxs);
    }
    
    .participant-name {
        font-weight: var(--font-weight-semibold);
        color: var(--blue-dark);
    }
    
    .program-stats {
        display: flex;
        justify-content: space-around;
        margin-bottom: var(--spacing-lg);
        padding: var(--spacing-md) 0;
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
        justify-content: flex-end;
    }
    
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: var(--spacing-xl);
        text-align: center;
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        margin-top: var(--spacing-xl);
        border: var(--border-width-thin) solid var(--blue-very-pale);
    }
    
    .empty-state svg {
        color: var(--blue-primary);
        margin-bottom: var(--spacing-md);
        opacity: 0.5;
    }
    
    .empty-state h2 {
        font-size: var(--font-size-lg);
        color: var(--blue-dark);
        margin-bottom: var(--spacing-sm);
    }
    
    .empty-state p {
        color: var(--dark-gray);
        margin-bottom: var(--spacing-lg);
    }
    
    @media (max-width: 768px) {
        .programs-header,
        .program-filters {
            flex-direction: column;
        }
        
        .search-box {
            max-width: 100%;
        }
        
        .filter-tabs {
            width: 100%;
        }
        
        .programs-grid {
            grid-template-columns: 1fr;
        }
        
        .program-participants {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtrage des programmes avec la recherche
    const searchInput = document.getElementById('program-search');
    const programCards = document.querySelectorAll('.program-card');
    const programsContainer = document.getElementById('programs-container');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let hasVisiblePrograms = false;
            
            programCards.forEach(card => {
                const programName = card.querySelector('h3').textContent.toLowerCase();
                const participantNames = card.querySelectorAll('.participant-name');
                let names = '';
                
                participantNames.forEach(name => {
                    names += name.textContent.toLowerCase() + ' ';
                });
                
                if (programName.includes(searchTerm) || names.includes(searchTerm)) {
                    card.style.display = 'block';
                    hasVisiblePrograms = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Gestion de l'état vide
            if (!hasVisiblePrograms) {
                if (!document.querySelector('.search-empty-state')) {
                    const emptyState = document.createElement('div');
                    emptyState.className = 'empty-state search-empty-state';
                    emptyState.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <h2>Aucun résultat trouvé</h2>
                        <p>Aucun programme ne correspond à votre recherche.</p>
                    `;
                    programsContainer.parentNode.appendChild(emptyState);
                }
            } else {
                const emptyState = document.querySelector('.search-empty-state');
                if (emptyState) {
                    emptyState.remove();
                }
            }
        });
    }
    
    // Filtrage par status (tous, actifs, terminés)
    const filterTabs = document.querySelectorAll('.filter-tab');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Supprimer la classe active de tous les onglets
            filterTabs.forEach(t => t.classList.remove('active'));
            
            // Ajouter la classe active à l'onglet cliqué
            this.classList.add('active');
            
            // Récupérer le filtre sélectionné
            const filter = this.dataset.filter;
            
            // Filtrer les programmes en fonction du filtre
            let hasVisiblePrograms = false;
            
            programCards.forEach(card => {
                if (filter === 'all' || 
                    (filter === 'active' && card.classList.contains('status-active')) ||
                    (filter === 'completed' && card.classList.contains('status-completed'))) {
                    card.style.display = 'block';
                    hasVisiblePrograms = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Gestion de l'état vide
            if (!hasVisiblePrograms) {
                if (!document.querySelector('.filter-empty-state')) {
                    const emptyState = document.createElement('div');
                    emptyState.className = 'empty-state filter-empty-state';
                    emptyState.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        <h2>Aucun programme ${filter === 'active' ? 'actif' : filter === 'completed' ? 'terminé' : ''}</h2>
                        <p>Aucun programme ne correspond au filtre sélectionné.</p>
                    `;
                    programsContainer.parentNode.appendChild(emptyState);
                }
            } else {
                const emptyState = document.querySelector('.filter-empty-state');
                if (emptyState) {
                    emptyState.remove();
                }
            }
        });
    });
});
</script>
@endsection
