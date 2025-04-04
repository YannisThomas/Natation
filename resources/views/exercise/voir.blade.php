@extends('layouts.base')
@section('title', 'Bibliothèque d\'exercices - Aquafit')
@section('content')

<div class="exercises-library-container">
    <div class="exercises-header">
        <div class="page-title-section">
            <h1>Bibliothèque d'exercices</h1>
            <p class="page-description">Consultez tous les exercices disponibles pour créer vos programmes d'entraînement.</p>
        </div>
        
        <div class="actions-container">
            <a href="{{ url('/exercice/creation') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Nouvel exercice
            </a>
        </div>
    </div>
    
    <div class="filters-section">
        <div class="search-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" class="search-icon">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="exercise-search" placeholder="Rechercher un exercice..." class="search-input">
        </div>
        
        <div class="filter-dropdown">
            <select id="category-filter" class="form-select">
                <option value="all">Toutes les catégories</option>
                @php
                    $categories = collect($exercises)->map(function($exercise) {
                        return $exercise->category->name ?? 'Sans catégorie';
                    })->unique()->sort()->values();
                @endphp
                
                @foreach($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="view-options">
            <button class="view-btn active" data-view="grid">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
            </button>
            <button class="view-btn" data-view="list">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
    
    <div class="exercises-count">
        <span id="filtered-count">{{ count($exercises) }}</span> exercices trouvés
    </div>
    
    <div class="exercises-grid" id="exercises-container">
        @foreach ($exercises as $exercise)
            <div class="exercise-card" data-category="{{ $exercise->category->name ?? 'Sans catégorie' }}">
                <div class="exercise-header">
                    <h3>{{ $exercise->name }}</h3>
                    <div class="category-badge">{{ $exercise->category->name ?? 'Sans catégorie' }}</div>
                </div>
                
                <div class="exercise-body">
                    @if($exercise->description)
                        <div class="exercise-description">
                            <p>{{ $exercise->description }}</p>
                        </div>
                    @endif
                    
                    <div class="exercise-specs">
                        @if($exercise->duration)
                            <div class="spec-item">
                                <div class="spec-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <div class="spec-value">
                                    <span class="spec-label">Durée</span>
                                    <span class="spec-text">{{ $exercise->duration }} minutes</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($exercise->repetition)
                            <div class="spec-item">
                                <div class="spec-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <polyline points="17 1 21 5 17 9"></polyline>
                                        <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                                        <polyline points="7 23 3 19 7 15"></polyline>
                                        <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                                    </svg>
                                </div>
                                <div class="spec-value">
                                    <span class="spec-label">Répétitions</span>
                                    <span class="spec-text">{{ $exercise->repetition }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($exercise->weight)
                            <div class="spec-item">
                                <div class="spec-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path>
                                        <line x1="16" y1="8" x2="2" y2="22"></line>
                                        <line x1="17.5" y1="15" x2="9" y2="15"></line>
                                    </svg>
                                </div>
                                <div class="spec-value">
                                    <span class="spec-label">Poids</span>
                                    <span class="spec-text">{{ $exercise->weight }} Kg</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($exercise->distance)
                            <div class="spec-item">
                                <div class="spec-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M19 13h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2h2"></path>
                                        <path d="M7 13h10"></path>
                                        <path d="M7 13v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </div>
                                <div class="spec-value">
                                    <span class="spec-label">Distance</span>
                                    <span class="spec-text">{{ $exercise->distance }} m</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($exercise->type)
                            <div class="spec-item">
                                <div class="spec-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                    </svg>
                                </div>
                                <div class="spec-value">
                                    <span class="spec-label">Type</span>
                                    <span class="spec-text">{{ $exercise->type }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="exercise-actions">
                    <a href="#" class="btn btn-sm btn-outline">Détails</a>
                    <a href="#" class="btn btn-sm btn-primary">Ajouter au programme</a>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="empty-state" id="empty-state" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="8" y1="12" x2="16" y2="12"></line>
        </svg>
        <h3>Aucun exercice trouvé</h3>
        <p>Essayez de modifier vos filtres ou créez un nouvel exercice</p>
        <a href="{{ url('/exercice/creation') }}" class="btn btn-primary">Créer un exercice</a>
    </div>
</div>

<style>
    .exercises-library-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--spacing-md);
    }
    
    .exercises-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: var(--spacing-xl);
        flex-wrap: wrap;
        gap: var(--spacing-lg);
    }
    
    .page-title-section h1 {
        font-size: var(--font-size-2xl);
        color: var(--blue-dark);
        margin-bottom: var(--spacing-sm);
    }
    
    .page-description {
        color: var(--dark-gray);
        max-width: 600px;
    }
    
    .filters-section {
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        flex-wrap: wrap;
    }
    
    .search-box {
        flex-grow: 1;
        position: relative;
        max-width: 400px;
    }
    
    .search-input {
        width: 100%;
        padding: var(--spacing-sm) var(--spacing-md);
        padding-left: 2.5rem;
        border: var(--border-width) solid var(--blue-pale);
        border-radius: var(--border-radius-md);
        background-color: var(--white);
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
    
    .filter-dropdown {
        min-width: 200px;
    }
    
    .exercises-count {
        margin-bottom: var(--spacing-md);
        font-size: var(--font-size-sm);
        color: var(--dark-gray);
    }
    
    .exercises-count #filtered-count {
        font-weight: var(--font-weight-bold);
        color: var(--blue-primary);
    }
    
    .view-options {
        display: flex;
        gap: var(--spacing-xs);
    }
    
    .view-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--white);
        border: var(--border-width-thin) solid var(--blue-pale);
        border-radius: var(--border-radius-md);
        color: var(--blue-primary);
        cursor: pointer;
        transition: all var(--transition-normal) var(--transition-ease);
    }
    
    .view-btn:hover {
        background-color: var(--blue-very-pale);
    }
    
    .view-btn.active {
        background-color: var(--blue-primary);
        color: var(--white);
        border-color: var(--blue-primary);
    }
    
    .exercises-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: var(--spacing-lg);
    }
    
    .exercises-grid.list-view {
        grid-template-columns: 1fr;
    }
    
    .exercise-card {
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: all var(--transition-normal) var(--transition-ease);
        display: flex;
        flex-direction: column;
        border: var(--border-width-thin) solid var(--blue-very-pale);
    }
    
    .exercise-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--blue-pale);
    }
    
    .exercises-grid.list-view .exercise-card {
        display: grid;
        grid-template-columns: 3fr 1fr;
        align-items: center;
    }
    
    .exercises-grid.list-view .exercise-body {
        display: flex;
        align-items: center;
    }
    
    .exercises-grid.list-view .exercise-description {
        width: 40%;
    }
    
    .exercises-grid.list-view .exercise-specs {
        width: 60%;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }
    
    .exercises-grid.list-view .exercise-actions {
        justify-content: flex-end;
        border-top: none;
        border-left: var(--border-width-thin) solid var(--blue-very-pale);
        height: 100%;
        display: flex;
        align-items: center;
        padding-right: var(--spacing-lg);
    }
    
    .exercise-header {
        padding: var(--spacing-lg);
        border-bottom: var(--border-width-thin) solid var(--blue-very-pale);
        position: relative;
    }
    
    .exercise-header h3 {
        font-size: var(--font-size-lg);
        color: var(--blue-dark);
        margin-bottom: var(--spacing-xs);
    }
    
    .category-badge {
        display: inline-block;
        background-color: var(--blue-very-pale);
        color: var(--blue-dark);
        font-size: var(--font-size-xs);
        padding: var(--spacing-xxs) var(--spacing-sm);
        border-radius: var(--border-radius-sm);
    }
    
    .exercise-body {
        padding: var(--spacing-lg);
        flex-grow: 1;
    }
    
    .exercise-description {
        margin-bottom: var(--spacing-md);
        color: var(--dark-gray);
        font-size: var(--font-size-sm);
        line-height: 1.6;
    }
    
    .exercise-specs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: var(--spacing-md);
    }
    
    .spec-item {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }
    
    .spec-icon {
        width: 32px;
        height: 32px;
        background-color: var(--blue-very-pale);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--blue-primary);
        flex-shrink: 0;
    }
    
    .spec-value {
        display: flex;
        flex-direction: column;
    }
    
    .spec-label {
        font-size: var(--font-size-xs);
        color: var(--dark-gray);
    }
    
    .spec-text {
        font-weight: var(--font-weight-semibold);
        color: var(--blue-dark);
    }
    
    .exercise-actions {
        padding: var(--spacing-md) var(--spacing-lg);
        border-top: var(--border-width-thin) solid var(--blue-very-pale);
        display: flex;
        justify-content: space-between;
        gap: var(--spacing-sm);
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
    
    .empty-state h3 {
        font-size: var(--font-size-lg);
        color: var(--blue-dark);
        margin-bottom: var(--spacing-sm);
    }
    
    .empty-state p {
        color: var(--dark-gray);
        margin-bottom: var(--spacing-lg);
    }
    
    @media (max-width: 768px) {
        .exercises-header {
            flex-direction: column;
        }
        
        .filters-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-box {
            max-width: 100%;
        }
        
        .exercises-grid {
            grid-template-columns: 1fr;
        }
        
        .exercises-grid.list-view .exercise-card {
            grid-template-columns: 1fr;
        }
        
        .exercises-grid.list-view .exercise-body {
            flex-direction: column;
        }
        
        .exercises-grid.list-view .exercise-description,
        .exercises-grid.list-view .exercise-specs {
            width: 100%;
        }
        
        .exercises-grid.list-view .exercise-specs {
            grid-template-columns: 1fr 1fr;
        }
        
        .exercises-grid.list-view .exercise-actions {
            border-top: var(--border-width-thin) solid var(--blue-very-pale);
            border-left: none;
            padding: var(--spacing-md) var(--spacing-lg);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const exerciseSearch = document.getElementById('exercise-search');
    const categoryFilter = document.getElementById('category-filter');
    const viewButtons = document.querySelectorAll('.view-btn');
    const exercisesContainer = document.getElementById('exercises-container');
    const exerciseCards = document.querySelectorAll('.exercise-card');
    const filteredCount = document.getElementById('filtered-count');
    const emptyState = document.getElementById('empty-state');
    
    // Fonction pour filtrer les exercices
    function filterExercises() {
        const searchTerm = exerciseSearch.value.toLowerCase();
        const category = categoryFilter.value;
        
        let visibleCount = 0;
        
        exerciseCards.forEach(card => {
            const cardTitle = card.querySelector('h3').textContent.toLowerCase();
            const cardCategory = card.dataset.category;
            const cardDescription = card.querySelector('.exercise-description') ? 
                                   card.querySelector('.exercise-description').textContent.toLowerCase() : '';
            
            const matchesSearch = cardTitle.includes(searchTerm) || cardDescription.includes(searchTerm);
            const matchesCategory = category === 'all' || cardCategory === category;
            
            if (matchesSearch && matchesCategory) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Mettre à jour le compteur
        filteredCount.textContent = visibleCount;
        
        // Afficher ou masquer l'état vide
        if (visibleCount === 0) {
            emptyState.style.display = 'flex';
            exercisesContainer.style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            exercisesContainer.style.display = 'grid';
        }
    }
    
    // Écouteurs d'événements pour les filtres
    exerciseSearch.addEventListener('input', filterExercises);
    categoryFilter.addEventListener('change', filterExercises);
    
    // Changement de vue (grille/liste)
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const viewType = this.dataset.view;
            
            if (viewType === 'list') {
                exercisesContainer.classList.add('list-view');
            } else {
                exercisesContainer.classList.remove('list-view');
            }
        });
    });
    
    // Initialisation
    filterExercises();
});
</script>
@endsection
