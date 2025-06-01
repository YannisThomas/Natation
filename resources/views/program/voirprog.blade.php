@extends('layouts.base')
@section('title', 'Détail du programme - ' . $program->name)

@section('content')
<div class="program-detail-container">
    <div class="program-detail-header">
        <div class="program-title-section">
            <h1>{{ $program->name }}</h1>
            <div class="program-dates">
                <div class="date-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Du {{ \Carbon\Carbon::parse($program->start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($program->end_date)->format('d/m/Y') }}</span>
                </div>
                <div class="program-meta">
                    @php
                        $startDate = new DateTime($program->start_date);
                        $endDate = new DateTime($program->end_date);
                        $today = new DateTime();
                        $totalDays = $startDate->diff($endDate)->days + 1;
                        
                        // Calculer la progression basée sur les exercices terminés
                        $totalExercises = $program->exercises->count();
                        $completedExercises = $program->exercises->where('pivot.finished_at', '!=', null)->count();
                        $exerciseProgressPercent = $totalExercises > 0 ? round(($completedExercises / $totalExercises) * 100) : 0;
                        
                        $status = 'upcoming';
                        $statusText = 'À venir';
                        
                        if ($today >= $startDate && $today <= $endDate) {
                            $status = 'active';
                            $statusText = 'En cours';
                            // Utiliser la progression des exercices au lieu des jours
                            $progressPercent = $exerciseProgressPercent;
                        } elseif ($today > $endDate) {
                            $status = 'completed';
                            $statusText = 'Terminé';
                            $progressPercent = $exerciseProgressPercent;
                        } else {
                            $progressPercent = 0;
                        }
                        
                        // Si tous les exercices sont terminés, marquer comme terminé même si dans les dates
                        if ($completedExercises == $totalExercises && $totalExercises > 0) {
                            $status = 'completed';
                            $statusText = 'Terminé';
                            $progressPercent = 100;
                        }
                    @endphp
                    <div class="status-badge status-{{ $status }}">{{ $statusText }}</div>
                </div>
            </div>
        </div>
        <div class="program-actions">
            <a href="{{ url('/programmes/voir') }}" class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="program-progress-section">
        <h3>Progression du programme</h3>
        <div class="program-progress">
            <div class="progress-bar">
                <div class="progress-value" style="width: {{ $progressPercent }}%"></div>
            </div>
            <div class="progress-stats">
                <span class="progress-percent">{{ $progressPercent }}%</span>
                <span class="progress-exercises">{{ $completedExercises }} exercices terminés sur {{ $totalExercises }}</span>
            </div>
        </div>
    </div>

    <div class="program-exercises-section">
        <div class="section-header">
            <h2>Exercices du programme</h2>
            <div class="exercise-count">{{ $totalExercises }} exercices ({{ $completedExercises }} terminés)</div>
        </div>

        <div class="exercise-grid">
            @foreach ($program->exercises as $index => $exercise)
                <div class="exercise-card card-hoverable">
                    <div class="exercise-number">{{ $index + 1 }}</div>
                    <div class="exercise-header">
                        <h3>{{ $exercise->name }}</h3>
                        <div class="exercise-category">
                            <span class="category-badge">{{ $exercise->category->name ?? 'Sans catégorie' }}</span>
                        </div>
                    </div>
                    
                    <div class="exercise-details">
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
                                        <span class="spec-label">Répétition</span>
                                        <span class="spec-text">{{ $exercise->repetition }} fois</span>
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
                        </div>
                    </div>
                    
                    <div class="exercise-status">
                        @php
                            $isCompleted = $exercise->pivot->finished_at !== null;
                        @endphp
                        
                        @if($isCompleted)
                            <div class="status-completed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                <span>Terminé le {{ \Carbon\Carbon::parse($exercise->pivot->finished_at)->format('d/m/Y') }}</span>
                            </div>
                        @else
                            <div class="status-pending">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span>À faire</span>
                            </div>
                            
                            {{-- Bouton de validation pour les athlètes --}}
                            @if(Auth::user()->isAthlete() && $program->user_id == Auth::id())
                                <div class="exercise-actions">
                                    {{-- Version AJAX --}}
                                    <button class="btn-validate-exercise" 
                                            data-program-id="{{ $program->id }}" 
                                            data-exercise-id="{{ $exercise->id }}"
                                            data-exercise-name="{{ $exercise->name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Marquer comme terminé
                                    </button>
                                    
                                    {{-- Version fallback (formulaire classique) - masquée par défaut --}}
                                    <form action="{{ route('program.exercise.validate', [$program->id, $exercise->id]) }}" 
                                          method="POST" 
                                          style="display: none;" 
                                          class="fallback-form">
                                        @csrf
                                        <button type="submit" class="btn-validate-exercise-fallback">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            Marquer comme terminé (Fallback)
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .program-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--spacing-md);
    }
    
    .program-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: var(--spacing-xl);
        flex-wrap: wrap;
        gap: var(--spacing-lg);
    }
    
    .program-title-section h1 {
        font-size: var(--font-size-2xl);
        color: var(--blue-dark);
        margin-bottom: var(--spacing-sm);
    }
    
    .program-dates {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-md);
    }
    
    .date-badge {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        background-color: var(--blue-very-pale);
        color: var(--blue-dark);
        padding: var(--spacing-xs) var(--spacing-md);
        border-radius: var(--border-radius-pill);
        font-size: var(--font-size-sm);
    }
    
    .program-meta {
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
    }
    
    .status-badge {
        font-size: var(--font-size-xs);
        font-weight: var(--font-weight-semibold);
        padding: var(--spacing-xxs) var(--spacing-sm);
        border-radius: var(--border-radius-pill);
    }
    
    .status-active {
        background-color: var(--blue-primary);
        color: var(--white);
    }
    
    .status-completed {
        background-color: var(--success);
        color: var(--white);
    }
    
    .status-upcoming {
        background-color: var(--blue-pale);
        color: var(--blue-dark);
    }
    
    .program-progress-section {
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        margin-bottom: var(--spacing-xl);
        border: var(--border-width-thin) solid var(--blue-very-pale);
    }
    
    .program-progress-section h3 {
        margin-bottom: var(--spacing-md);
        color: var(--blue-dark);
        font-size: var(--font-size-lg);
    }
    
    .program-progress {
        margin-top: var(--spacing-md);
    }
    
    .progress-bar {
        height: 10px;
        background-color: var(--blue-very-pale);
        border-radius: var(--border-radius-pill);
        overflow: hidden;
        margin-bottom: var(--spacing-xs);
    }
    
    .progress-value {
        height: 100%;
        background: linear-gradient(90deg, var(--blue-primary), var(--blue-light));
        border-radius: var(--border-radius-pill);
        transition: width 0.5s ease;
    }
    
    .progress-stats {
        display: flex;
        justify-content: space-between;
        color: var(--blue-dark);
        font-size: var(--font-size-sm);
    }
    
    .progress-percent {
        font-weight: var(--font-weight-bold);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-lg);
    }
    
    .section-header h2 {
        font-size: var(--font-size-xl);
        color: var(--blue-dark);
        margin-bottom: 0;
    }
    
    .exercise-count {
        background-color: var(--blue-primary);
        color: var(--white);
        padding: var(--spacing-xs) var(--spacing-md);
        border-radius: var(--border-radius-pill);
        font-size: var(--font-size-sm);
        font-weight: var(--font-weight-semibold);
    }
    
    /* Styles pour la validation d'exercices */
    .exercise-actions {
        margin-top: var(--spacing-sm);
        display: flex;
        gap: var(--spacing-xs);
    }
    
    .btn-validate-exercise {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-medium));
        color: var(--white);
        border: none;
        padding: var(--spacing-xs) var(--spacing-md);
        border-radius: var(--border-radius-md);
        font-size: var(--font-size-sm);
        font-weight: var(--font-weight-semibold);
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(3, 4, 94, 0.2);
    }
    
    .btn-validate-exercise:hover {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-primary));
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(3, 4, 94, 0.3);
    }
    
    .btn-validate-exercise:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(3, 4, 94, 0.2);
    }
    
    .btn-validate-exercise:disabled {
        background: var(--gray-medium);
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    .btn-validate-exercise-fallback {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        background: linear-gradient(135deg, var(--blue-medium), var(--blue-primary));
        color: var(--white);
        border: none;
        padding: var(--spacing-xs) var(--spacing-md);
        border-radius: var(--border-radius-md);
        font-size: var(--font-size-sm);
        font-weight: var(--font-weight-semibold);
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(3, 4, 94, 0.2);
    }
    
    .btn-validate-exercise-fallback:hover {
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-dark));
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(3, 4, 94, 0.3);
    }
    
    .exercise-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: var(--spacing-lg);
    }
    
    .exercise-card {
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        padding: var(--spacing-lg);
        position: relative;
        transition: all var(--transition-normal) var(--transition-ease);
        border: var(--border-width-thin) solid var(--blue-very-pale);
    }
    
    .card-hoverable:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--blue-pale);
    }
    
    .exercise-number {
        position: absolute;
        top: -10px;
        left: -10px;
        width: 30px;
        height: 30px;
        background-color: var(--blue-primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: var(--font-weight-bold);
        box-shadow: var(--shadow-sm);
        z-index: 1;
    }
    
    .exercise-header {
        margin-bottom: var(--spacing-md);
        border-bottom: 1px solid var(--blue-very-pale);
        padding-bottom: var(--spacing-md);
    }
    
    .exercise-header h3 {
        font-size: var(--font-size-md);
        color: var(--blue-primary);
        margin-bottom: var(--spacing-xs);
    }
    
    .exercise-category {
        margin-top: var(--spacing-xs);
    }
    
    .category-badge {
        display: inline-block;
        background-color: var(--blue-very-pale);
        color: var(--blue-dark);
        font-size: var(--font-size-xs);
        padding: var(--spacing-xxs) var(--spacing-sm);
        border-radius: var(--border-radius-sm);
    }
    
    .exercise-details {
        margin-bottom: var(--spacing-md);
    }
    
    .exercise-description {
        margin-bottom: var(--spacing-md);
        color: var(--dark-gray);
        font-size: var(--font-size-sm);
        line-height: 1.6;
    }
    
    .exercise-specs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour mettre à jour la progression du programme
    function updateProgramProgress() {
        const exerciseCards = document.querySelectorAll('.exercise-card');
        const totalExercises = exerciseCards.length;
        let completedExercises = 0;
        
        exerciseCards.forEach(card => {
            const statusCompleted = card.querySelector('.status-completed');
            if (statusCompleted) {
                completedExercises++;
            }
        });
        
        const progressPercent = totalExercises > 0 ? Math.round((completedExercises / totalExercises) * 100) : 0;
        
        // Mettre à jour la barre de progression
        const progressBar = document.querySelector('.progress-value');
        const progressPercentSpan = document.querySelector('.progress-percent');
        const progressExercisesSpan = document.querySelector('.progress-exercises');
        const exerciseCount = document.querySelector('.exercise-count');
        
        if (progressBar) progressBar.style.width = progressPercent + '%';
        if (progressPercentSpan) progressPercentSpan.textContent = progressPercent + '%';
        if (progressExercisesSpan) progressExercisesSpan.textContent = `${completedExercises} exercices terminés sur ${totalExercises}`;
        if (exerciseCount) exerciseCount.textContent = `${totalExercises} exercices (${completedExercises} terminés)`;
        
        // Mettre à jour le statut du programme si tous les exercices sont terminés
        if (completedExercises === totalExercises && totalExercises > 0) {
            const statusBadge = document.querySelector('.status-badge');
            if (statusBadge) {
                statusBadge.className = 'status-badge status-completed';
                statusBadge.textContent = 'Terminé';
            }
        }
    }

    // Gestion de la validation d'exercices
    const validateButtons = document.querySelectorAll('.btn-validate-exercise');
    
    validateButtons.forEach(button => {
        button.addEventListener('click', function() {
            const programId = this.dataset.programId;
            const exerciseId = this.dataset.exerciseId;
            const exerciseName = this.dataset.exerciseName;
            
            // Confirmation avant validation
            if (!confirm(`Êtes-vous sûr de vouloir marquer l'exercice "${exerciseName}" comme terminé ?`)) {
                return;
            }
            
            // Désactiver le bouton pendant la requête
            this.disabled = true;
            this.innerHTML = '<span>Validation...</span>';
            
            // Requête AJAX pour valider l'exercice
            console.log('Validation exercice:', { programId, exerciseId, userId: {{ Auth::id() }} });
            
            fetch(`/programme/valider/${programId}/exercice/${exerciseId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                
                if (data.success) {
                    // Succès : mettre à jour l'interface sans recharger
                    alert('Exercice validé avec succès !');
                    
                    // Mettre à jour le statut de l'exercice
                    const exerciseCard = this.closest('.exercise-card');
                    const statusDiv = exerciseCard.querySelector('.exercise-status');
                    
                    // Ajouter l'animation de completion
                    exerciseCard.classList.add('just-completed');
                    
                    statusDiv.innerHTML = `
                        <div class="status-completed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Terminé le ${data.finished_at || 'maintenant'}</span>
                        </div>
                    `;
                    
                    // Mettre à jour la progression avec un délai pour l'animation
                    setTimeout(() => {
                        updateProgramProgress();
                    }, 300);
                    
                    // Masquer le bouton de validation
                    this.parentElement.style.display = 'none';
                    
                    // Retirer l'animation après un délai
                    setTimeout(() => {
                        exerciseCard.classList.remove('just-completed');
                    }, 1500);
                } else {
                    alert('Erreur lors de la validation : ' + (data.error || 'Erreur inconnue'));
                    // Réactiver le bouton en cas d'erreur
                    this.disabled = false;
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Marquer comme terminé
                    `;
                }
            })
            .catch(error => {
                console.error('Erreur détaillée:', error);
                
                // Proposer le fallback après 2 échecs
                const failureCount = parseInt(this.dataset.failureCount || '0') + 1;
                this.dataset.failureCount = failureCount;
                
                if (failureCount >= 2) {
                    const useClassicForm = confirm(`Erreur AJAX persistante: ${error.message}.\n\nVoulez-vous utiliser le formulaire classique à la place ?`);
                    if (useClassicForm) {
                        // Masquer le bouton AJAX et montrer le formulaire
                        this.style.display = 'none';
                        const fallbackForm = this.parentElement.querySelector('.fallback-form');
                        if (fallbackForm) {
                            fallbackForm.style.display = 'block';
                        }
                        return;
                    }
                }
                
                alert(`Erreur de connexion (tentative ${failureCount}): ${error.message}.\nVérifiez la console pour plus de détails.`);
                
                // Réactiver le bouton en cas d'erreur
                this.disabled = false;
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Marquer comme terminé
                `;
            });
        });
    });
});
</script>

<style>
    .spec-text {
        font-weight: var(--font-weight-semibold);
        color: var(--blue-dark);
    }
    
    .exercise-status {
        margin-top: var(--spacing-md);
        padding-top: var(--spacing-md);
        border-top: 1px solid var(--blue-very-pale);
        display: flex;
        justify-content: flex-end;
    }
    
    .status-completed, .status-pending {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        font-size: var(--font-size-sm);
        padding: var(--spacing-xs) var(--spacing-md);
        border-radius: var(--border-radius-pill);
    }
    
    .status-completed {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    
    .status-pending {
        background-color: var(--blue-very-pale);
        color: var(--blue-dark);
    }
    
    /* Animation pour la progression mise à jour */
    .progress-value {
        transition: width 0.8s ease-in-out;
    }
    
    /* Animation pour les badges de statut */
    .status-badge {
        transition: all 0.3s ease;
    }
    
    .status-completed {
        animation: completedPulse 0.6s ease-in-out;
    }
    
    @keyframes completedPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); background-color: #d1e7dd; }
        100% { transform: scale(1); }
    }
    
    /* Style pour les exercices nouvellement terminés */
    .exercise-card.just-completed {
        border-color: #198754;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
        animation: exerciseCompleted 1s ease-in-out;
    }
    
    @keyframes exerciseCompleted {
        0% { border-color: var(--blue-primary); box-shadow: 0 2px 8px var(--shadow-light); }
        50% { border-color: #198754; box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3); }
        100% { border-color: #198754; box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2); }
    }
    
    @media (max-width: 768px) {
        .program-detail-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .program-dates {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .exercise-grid {
            grid-template-columns: 1fr;
        }
        
        .exercise-specs {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>
@endsection
