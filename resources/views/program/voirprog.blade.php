@extends('layouts.base')
@section('title', 'Détail du programme - ' . $programs->name)

@section('content')
<div class="program-detail-container">
    <div class="program-detail-header">
        <div class="program-title-section">
            <h1>{{ $programs->name }}</h1>
            <div class="program-dates">
                <div class="date-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Du {{ \Carbon\Carbon::parse($programs->start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($programs->end_date)->format('d/m/Y') }}</span>
                </div>
                <div class="program-meta">
                    @php
                        $startDate = new DateTime($programs->start_date);
                        $endDate = new DateTime($programs->end_date);
                        $today = new DateTime();
                        $totalDays = $startDate->diff($endDate)->days + 1;
                        
                        $status = 'upcoming';
                        $statusText = 'À venir';
                        
                        if ($today >= $startDate && $today <= $endDate) {
                            $status = 'active';
                            $statusText = 'En cours';
                            
                            $elapsedDays = $startDate->diff($today)->days + 1;
                            $progressPercent = min(100, round(($elapsedDays / $totalDays) * 100));
                        } elseif ($today > $endDate) {
                            $status = 'completed';
                            $statusText = 'Terminé';
                            $progressPercent = 100;
                        } else {
                            $progressPercent = 0;
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
                <span class="progress-days">{{ $startDate->diff($today)->days > 0 ? $startDate->diff($today)->days : 0 }} jours écoulés sur {{ $totalDays }}</span>
            </div>
        </div>
    </div>

    <div class="program-exercises-section">
        <div class="section-header">
            <h2>Exercices du programme</h2>
            <div class="exercise-count">{{ count($programs->exercises) }} exercices</div>
        </div>

        <div class="exercise-grid">
            @foreach ($programs->exercises as $index => $exercise)
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
                            $isCompleted = false; // Remplacer par la vraie logique selon votre modèle
                        @endphp
                        
                        @if($isCompleted)
                            <div class="status-completed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                <span>Terminé</span>
                            </div>
                        @else
                            <div class="status-pending">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span>À faire</span>
                            </div>
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
