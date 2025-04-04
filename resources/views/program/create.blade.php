@extends('layouts.base')
@section('title', 'Création de Programme')
@section('content')

<div class="program-creation-section">
    <div class="program-header">
        <h1>Création de Programme d'Entraînement</h1>
        <div class="coach-badge">
            <div class="coach-avatar">
                {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
            </div>
            <div class="coach-info">
                <span class="coach-role">{{ Auth::user()->isAdmin() ? 'Administrateur' : 'Coach' }}</span>
                <span class="coach-name">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
            </div>
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

    <div class="form-container">
        <form method="POST" action="{{ route('program.create.post') }}" class="program-form">
            @csrf
            <div class="form-header">
                <h2>Informations du programme</h2>
                <p>Remplissez les informations ci-dessous pour créer un nouveau programme d'entraînement.</p>
                
                <div class="form-progress">
                    <div class="progress-step active" data-step="1">
                        <div class="step-indicator">1</div>
                        <div class="step-label">Informations</div>
                    </div>
                    <div class="progress-connector"></div>
                    <div class="progress-step" data-step="2">
                        <div class="step-indicator">2</div>
                        <div class="step-label">Athlète</div>
                    </div>
                    <div class="progress-connector"></div>
                    <div class="progress-step" data-step="3">
                        <div class="step-indicator">3</div>
                        <div class="step-label">Exercices</div>
                    </div>
                </div>
            </div>
            
            <div class="form-sections-container">
                <!-- Étape 1: Informations de base -->
                <div class="form-section active" data-section="1">
                    <div class="form-group">
                        <label for="name" class="form-label required">Nom du programme</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Ex: Programme natation été 2025" required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_date" class="form-label required">Date de début</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                            @error('start_date')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="end_date" class="form-label required">Date de fin</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                            @error('end_date')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-description">
                        <label for="description" class="form-label">Description (optionnel)</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Décrivez l'objectif de ce programme et les résultats attendus..."></textarea>
                    </div>
                    
                    <div class="form-navigation">
                        <div></div>
                        <button type="button" class="btn btn-primary next-step">
                            Continuer
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Étape 2: Choix de l'athlète -->
                <div class="form-section" data-section="2">
                    <div class="form-group">
                        <label for="user_id" class="form-label required">Athlète</label>
                        <div class="athlete-selector">
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">-- Sélectionnez un athlète --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p class="form-hint">Sélectionnez l'athlète pour qui ce programme est créé.</p>
                        @error('user_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="athlete-preview">
                        <div class="preview-placeholder" id="athletePlaceholder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg>
                            <p>Sélectionnez un athlète pour voir ses informations</p>
                        </div>
                        
                        <div class="athlete-details" id="athleteDetails" style="display: none">
                            <div class="athlete-header">
                                <div class="athlete-avatar">
                                    <span id="athleteInitials"></span>
                                </div>
                                <div class="athlete-identity">
                                    <h3 id="athleteName"></h3>
                                    <div class="athlete-email" id="athleteEmail"></div>
                                </div>
                            </div>
                            
                            <div class="athlete-stats">
                                <div class="stat-card">
                                    <div class="stat-number" id="programCount">0</div>
                                    <div class="stat-label">Programmes</div>
                                </div>
                                
                                <div class="stat-card" id="lastProgramCard" style="display: none">
                                    <div class="stat-header">Dernier programme</div>
                                    <div class="stat-content">
                                        <div class="stat-program-name" id="lastProgramName"></div>
                                        <div class="stat-program-date" id="lastProgramDate"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="athlete-actions">
                                <button type="button" class="btn btn-sm btn-outline" id="chooseAnotherAthlete">
                                    Choisir un autre athlète
                                </button>
                            </div>
                        </div>
                        
                        <div class="loading-indicator" id="loadingIndicator" style="display: none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="spin">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56"></path>
                            </svg>
                            <span>Chargement des informations...</span>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline prev-step">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M19 12H5M12 19l-7-7 7-7"/>
                            </svg>
                            Retour
                        </button>
                        <button type="button" class="btn btn-primary next-step">
                            Continuer
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Étape 3: Choix des exercices -->
                <div class="form-section" data-section="3">
                    <div class="form-group">
                        <label for="exercise_category" class="form-label">Filtrer par catégorie</label>
                        <select id="exercise_category" class="form-select">
                            <option value="all">Toutes les catégories</option>
                            <!-- Options des catégories générées dynamiquement -->
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exercise_search" class="form-label">Rechercher un exercice</label>
                        <div class="input-group">
                            <input type="text" id="exercise_search" class="form-control" placeholder="Nom de l'exercice">
                            <button type="button" class="btn btn-secondary" id="clearSearch">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Sélectionnez les exercices</label>
                        <div class="exercise-selection-container">
                            <div class="available-exercises" id="availableExercises">
                                <div class="exercise-list-header">
                                    <h4>Exercices disponibles</h4>
                                    <span class="count" id="availableCount">0</span>
                                </div>
                                <div class="exercise-list" id="exerciseList">
                                    <!-- Les exercices seront ajoutés ici -->
                                    @foreach ($exercices as $exercice)
                                        <div class="exercise-item" data-id="{{ $exercice->id }}" data-category="{{ $exercice->category->name ?? 'Sans catégorie' }}">
                                            <div class="exercise-details">
                                                <h5>{{ $exercice->name }}</h5>
                                                <div class="exercise-meta">
                                                    <span class="category">{{ $exercice->category->name ?? 'Sans catégorie' }}</span>
                                                    @if($exercice->duration)
                                                        <span class="duration">{{ $exercice->duration }} min</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <button type="button" class="btn-add-exercise" data-id="{{ $exercice->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                    <path d="M12 5v14M5 12h14"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="selected-exercises" id="selectedExercises">
                                <div class="exercise-list-header">
                                    <h4>Exercices sélectionnés</h4>
                                    <span class="count" id="selectedCount">0</span>
                                </div>
                                <div class="exercise-list" id="selectedList">
                                    <!-- Les exercices sélectionnés seront ajoutés ici -->
                                    <div class="empty-selection" id="emptySelection">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <path d="M14 2v6h6"/>
                                            <path d="M16 13H8"/>
                                            <path d="M16 17H8"/>
                                            <path d="M10 9H8"/>
                                        </svg>
                                        <p>Aucun exercice sélectionné</p>
                                        <p class="hint">Ajoutez des exercices de la liste de gauche</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Champ hidden pour stocker les IDs des exercices sélectionnés -->
                            <select name="exercise_id[]" id="exercise_id" class="hidden-select" multiple required>
                                <!-- Options générées par JavaScript -->
                            </select>
                        </div>
                        @error('exercise_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline prev-step">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M19 12H5M12 19l-7-7 7-7"/>
                            </svg>
                            Retour
                        </button>
                        <button type="submit" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                            Créer le programme
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

<style>
.form-container {
    margin-top: var(--spacing-xl);
}

.program-form {
    background-color: var(--white);
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-lg);
    border: var(--border-width-thin) solid var(--blue-very-pale);
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-primary));
    color: var(--white);
    padding: var(--spacing-xl) var(--spacing-xl) var(--spacing-lg);
    position: relative;
}

.form-header h2 {
    color: var(--white);
    margin-bottom: var(--spacing-sm);
}

.form-header p {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: var(--spacing-lg);
}

.form-progress {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: var(--spacing-xl);
    padding: 0 var(--spacing-md);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-xs);
    position: relative;
    z-index: 1;
}

.step-indicator {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.3);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: var(--font-weight-bold);
    transition: all var(--transition-normal) var(--transition-ease);
}

.step-label {
    font-size: var(--font-size-sm);
    color: rgba(255, 255, 255, 0.8);
    transition: all var(--transition-normal) var(--transition-ease);
}

.progress-step.active .step-indicator {
    background-color: var(--white);
    color: var(--blue-primary);
    box-shadow: var(--shadow-md);
    transform: scale(1.1);
}

.progress-step.active .step-label {
    color: var(--white);
    font-weight: var(--font-weight-medium);
}

.progress-step.completed .step-indicator {
    background-color: var(--blue-light);
    color: var(--white);
}

.progress-connector {
    flex: 1;
    height: 3px;
    background-color: rgba(255, 255, 255, 0.3);
    position: relative;
    margin: 0 var(--spacing-sm);
}

.progress-connector::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background-color: var(--white);
    transition: width var(--transition-normal) var(--transition-ease);
}

.progress-step[data-step="2"].active ~ .progress-connector:first-of-type::after,
.progress-step[data-step="2"].completed ~ .progress-connector:first-of-type::after {
    width: 100%;
}

.progress-step[data-step="3"].active ~ .progress-connector::after,
.progress-step[data-step="3"].completed ~ .progress-connector::after {
    width: 100%;
}

.form-sections-container {
    position: relative;
    min-height: 500px;
}

.form-section {
    padding: var(--spacing-xl);
    display: none;
    animation: fadeIn var(--transition-normal) var(--transition-ease);
}

.form-section.active {
    display: block;
}

.form-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: var(--spacing-xl);
    padding-top: var(--spacing-lg);
    border-top: 1px solid var(--blue-very-pale);
}

.form-navigation .btn {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

/* Athlète Preview */
.athlete-preview {
    margin-top: var(--spacing-lg);
    background-color: var(--blue-very-pale);
    border-radius: var(--border-radius-md);
    padding: var(--spacing-lg);
}

.preview-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-xl);
    color: var(--blue-dark);
    opacity: 0.7;
    text-align: center;
}

.preview-placeholder svg {
    margin-bottom: var(--spacing-md);
    color: var(--blue-primary);
}

.preview-placeholder .hint {
    font-size: var(--font-size-sm);
    color: var(--blue-primary);
    margin-top: var(--spacing-xs);
}

/* Exercice Selection */
.exercise-selection-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-lg);
    margin-top: var(--spacing-md);
}

.available-exercises,
.selected-exercises {
    background-color: var(--white);
    border: var(--border-width-thin) solid var(--blue-pale);
    border-radius: var(--border-radius-md);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 500px;
}

.exercise-list-header {
    padding: var(--spacing-sm) var(--spacing-md);
    background-color: var(--blue-very-pale);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: var(--border-width-thin) solid var(--blue-pale);
}

.exercise-list-header h4 {
    margin: 0;
    font-size: var(--font-size-base);
    color: var(--blue-dark);
}

.count {
    background-color: var(--blue-primary);
    color: var(--white);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-semibold);
}

.exercise-list {
    overflow-y: auto;
    padding: var(--spacing-sm);
    flex: 1;
}

.exercise-item {
    padding: var(--spacing-sm);
    border-radius: var(--border-radius-sm);
    background-color: var(--white);
    border: var(--border-width-thin) solid var(--blue-very-pale);
    margin-bottom: var(--spacing-sm);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all var(--transition-normal) var(--transition-ease);
}

.exercise-item:hover {
    border-color: var(--blue-pale);
    box-shadow: var(--shadow-sm);
    transform: translateY(-2px);
}

.exercise-details {
    flex: 1;
}

.exercise-details h5 {
    margin: 0;
    font-size: var(--font-size-base);
    color: var(--blue-dark);
}

.exercise-meta {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    margin-top: var(--spacing-xxs);
}

.category,
.duration {
    font-size: var(--font-size-xs);
    padding: 2px 6px;
    border-radius: 4px;
}

.category {
    background-color: var(--blue-very-pale);
    color: var(--blue-dark);
}

.duration {
    background-color: var(--blue-pale);
    color: var(--blue-dark);
}

.btn-add-exercise,
.btn-remove-exercise {
    border: none;
    background-color: var(--blue-very-pale);
    color: var(--blue-primary);
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition-normal) var(--transition-ease);
}

.btn-add-exercise:hover {
    background-color: var(--blue-primary);
    color: var(--white);
}

.btn-remove-exercise {
    background-color: #ffe5e5;
    color: var(--danger);
}

.btn-remove-exercise:hover {
    background-color: var(--danger);
    color: var(--white);
}

.empty-selection {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    min-height: 200px;
    text-align: center;
    color: var(--blue-dark);
    opacity: 0.7;
}

.empty-selection svg {
    margin-bottom: var(--spacing-md);
    color: var(--blue-primary);
}

.empty-selection .hint {
    font-size: var(--font-size-sm);
    color: var(--blue-primary);
    margin-top: var(--spacing-xs);
}

.hidden-select {
    display: none;
}

/* Responsive styles */
@media (max-width: 768px) {
    .exercise-selection-container {
        grid-template-columns: 1fr;
    }
    
    .form-progress {
        padding: 0;
    }
    
    .progress-step {
        transform: scale(0.8);
    }
    
    .step-label {
        font-size: 10px;
    }
    
    .form-section {
        padding: var(--spacing-md);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log("Initialisation du formulaire de création de programme");
    
    // Gestion des étapes du formulaire
    const steps = document.querySelectorAll('.progress-step');
    const sections = document.querySelectorAll('.form-section');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    
    // Éléments pour la gestion des exercices (déclarés en début de script)
    const exerciseList = document.getElementById('exerciseList');
    const selectedList = document.getElementById('selectedList');
    const hiddenSelect = document.getElementById('exercise_id');
    const emptySelection = document.getElementById('emptySelection');
    const categoryFilter = document.getElementById('exercise_category');
    const searchInput = document.getElementById('exercise_search');
    const clearButton = document.getElementById('clearSearch');
    
    // Gestion des détails de l'athlète (déclarés en début de script)
    const athleteSelect = document.getElementById('user_id');
    const athletePlaceholder = document.getElementById('athletePlaceholder');
    const athleteDetails = document.getElementById('athleteDetails');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const chooseAnotherAthleteBtn = document.getElementById('chooseAnotherAthlete');
    
    // Fonction pour mettre à jour le compteur d'exercices disponibles
    function updateAvailableCount() {
        if (!exerciseList) return; // Sécurité si l'élément n'existe pas
        
        const visibleItems = Array.from(exerciseList.querySelectorAll('.exercise-item')).filter(item => {
            return item.style.display !== 'none';
        });
        const countElement = document.getElementById('availableCount');
        if (countElement) {
            countElement.textContent = visibleItems.length;
        }
    }
    
    // Fonction pour mettre à jour le compteur d'exercices sélectionnés
    function updateSelectedCount() {
        if (!selectedList) return; // Sécurité si l'élément n'existe pas
        
        const selectedItems = selectedList.querySelectorAll('.exercise-item').length;
        const countElement = document.getElementById('selectedCount');
        if (countElement) {
            countElement.textContent = selectedItems;
        }
    }
    
    // Initialisation des compteurs seulement s'ils existent
    if (exerciseList && selectedList) {
        updateAvailableCount();
        updateSelectedCount();
    }
    
    // Initialisation des dates par défaut
    const today = new Date();
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    // Format YYYY-MM-DD pour les inputs de type date
    const formatDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };
    
    // Date de début = aujourd'hui
    startDateInput.value = formatDate(today);
    
    // Date de fin = 1 mois après la date de début
    const endDate = new Date(today);
    endDate.setMonth(endDate.getMonth() + 1);
    endDateInput.value = formatDate(endDate);
    
    console.log("Dates initialisées - début:", startDateInput.value, "fin:", endDateInput.value);
    
    // Fonction pour aller à une étape
    function goToStep(stepNumber) {
        console.log(`Tentative de passer à l'étape ${stepNumber}`);
        
        // Vérifier les champs obligatoires avant de changer d'étape
        if (stepNumber > 1) {
            const currentSection = document.querySelector(`.form-section[data-section="${stepNumber - 1}"]`);
            const requiredFields = currentSection.querySelectorAll('input[required], select[required]');
            let isValid = true;
            
            console.log(`Vérification de ${requiredFields.length} champs obligatoires dans la section ${stepNumber - 1}`);
            
            requiredFields.forEach(field => {
                console.log(`Champ ${field.name}: valeur=${field.value}`);
                if (!field.value) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    // Ajouter un message d'erreur si nécessaire
                    const errorMsgElement = field.nextElementSibling;
                    if (!errorMsgElement || !errorMsgElement.classList.contains('form-error')) {
                        const errorMsg = document.createElement('div');
                        errorMsg.classList.add('form-error');
                        errorMsg.textContent = 'Ce champ est obligatoire';
                        field.parentNode.insertBefore(errorMsg, field.nextSibling);
                    }
                } else {
                    field.classList.remove('is-invalid');
                    
                    // Supprimer le message d'erreur s'il existe
                    const errorMsgElement = field.nextElementSibling;
                    if (errorMsgElement && errorMsgElement.classList.contains('form-error')) {
                        errorMsgElement.remove();
                    }
                }
            });
            
            if (!isValid) {
                console.log('Formulaire invalide - étape bloquée');
                return;
            }
            
            console.log('Formulaire valide - passage à l\'étape suivante');
        }
        
        // Si on passe à l'étape 2, charger les détails de l'athlète
        if (stepNumber === 2) {
            const athleteSelect = document.getElementById('user_id');
            if (athleteSelect.value) {
                console.log(`Chargement des détails de l'athlète avec ID: ${athleteSelect.value}`);
                loadAthleteDetails(athleteSelect.value);
            }
        }
        
        // Mettre à jour les steps
        steps.forEach(step => {
            const stepNum = parseInt(step.dataset.step);
            if (stepNum < stepNumber) {
                step.classList.add('completed');
                step.classList.remove('active');
            } else if (stepNum === stepNumber) {
                step.classList.add('active');
                step.classList.remove('completed');
            } else {
                step.classList.remove('active', 'completed');
            }
        });
        
        // Mettre à jour les sections
        sections.forEach(section => {
            const sectionNum = parseInt(section.dataset.section);
            if (sectionNum === stepNumber) {
                section.classList.add('active');
            } else {
                section.classList.remove('active');
            }
        });
        
        console.log(`Passage à l'étape ${stepNumber} réussi`);
    }
    
    // Écouteurs d'événements pour les boutons suivant/précédent
    nextButtons.forEach(button => {
        console.log("Initialisation d'un bouton 'suivant'");
        button.addEventListener('click', function(event) {
            console.log("Clic sur bouton 'suivant'");
            // Empêcher le comportement par défaut pour éviter la soumission du formulaire
            event.preventDefault();
            
            const currentSection = this.closest('.form-section');
            console.log("Section actuelle:", currentSection);
            
            const currentStep = parseInt(currentSection.dataset.section);
            console.log("Étape actuelle:", currentStep, "Passage à l'étape:", currentStep + 1);
            
            // Debug visuel
            this.classList.add('btn-clicked');
            setTimeout(() => {
                this.classList.remove('btn-clicked');
            }, 500);
            
            goToStep(currentStep + 1);
        });
    });
    
    prevButtons.forEach(button => {
        console.log("Initialisation d'un bouton 'précédent'");
        button.addEventListener('click', function(event) {
            console.log("Clic sur bouton 'précédent'");
            // Empêcher le comportement par défaut
            event.preventDefault();
            
            const currentSection = this.closest('.form-section');
            const currentStep = parseInt(currentSection.dataset.section);
            console.log("Retour de l'étape", currentStep, "à l'étape:", currentStep - 1);
            
            goToStep(currentStep - 1);
        });
    });
    
    // Ces éléments sont déjà définis au début du script
    // Aucun besoin de les redéclarer ici
    
    // Charger les détails de l'athlète lorsqu'un athlète est sélectionné
    athleteSelect.addEventListener('change', function() {
        if (this.value) {
            loadAthleteDetails(this.value);
        } else {
            showAthletePlaceholder();
        }
    });
    
    // Bouton "Choisir un autre athlète"
    chooseAnotherAthleteBtn.addEventListener('click', function() {
        showAthletePlaceholder();
        athleteSelect.value = '';
    });
    
    // Fonction pour charger les détails de l'athlète
    function loadAthleteDetails(athleteId) {
        // Afficher l'indicateur de chargement
        athletePlaceholder.style.display = 'none';
        athleteDetails.style.display = 'none';
        loadingIndicator.style.display = 'flex';
        
        console.log(`Chargement des détails pour l'athlète ${athleteId}`);
        
        // Appel API pour récupérer les détails de l'athlète
        fetch(`/api/athlete/${athleteId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Statut de la réponse:', response.status);
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.error || 'Impossible de récupérer les informations de l\'athlète');
                }).catch(e => {
                    if (e instanceof SyntaxError) {
                        throw new Error(`Erreur ${response.status}: ${response.statusText}`);
                    }
                    throw e;
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Données reçues:', data);
            // Masquer l'indicateur de chargement
            loadingIndicator.style.display = 'none';
            
            // Afficher les détails de l'athlète
            document.getElementById('athleteInitials').textContent = data.firstname.charAt(0) + data.lastname.charAt(0);
            document.getElementById('athleteName').textContent = data.firstname + ' ' + data.lastname;
            document.getElementById('athleteEmail').textContent = data.email;
            document.getElementById('programCount').textContent = data.program_count;
            
            // Gérer l'affichage du dernier programme
            if (data.last_program) {
                document.getElementById('lastProgramCard').style.display = 'block';
                document.getElementById('lastProgramName').textContent = data.last_program.name;
                
                // Formatage de la date
                const endDate = new Date(data.last_program.end_date);
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('lastProgramDate').textContent = 'Terminé le ' + endDate.toLocaleDateString('fr-FR', options);
            } else {
                document.getElementById('lastProgramCard').style.display = 'none';
            }
            
            // Afficher les détails
            athleteDetails.style.display = 'block';
        })
        .catch(error => {
            console.error('Erreur:', error);
            loadingIndicator.style.display = 'none';
            
            // Créer un élément d'alerte pour l'erreur avec plus d'informations de débogage
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger';
            errorAlert.style.marginTop = '1rem';
            errorAlert.style.marginBottom = '1rem';
            
            // Ajouter un identifiant pour le débogage
            errorAlert.id = 'athlete-error-debug';
            
            // Afficher des informations détaillées pour le débogage
            let errorDetails = `<strong>Erreur de chargement des données de l'athlète</strong><br>`;
            errorDetails += `Message: ${error.message}<br>`;
            errorDetails += `URL appelée: /api/athlete/${athleteId}<br>`;
            errorDetails += `Heure: ${new Date().toLocaleTimeString()}<br>`;
            errorDetails += `<button class="btn btn-sm btn-outline" onclick="retryAthleteLoad(${athleteId})">Réessayer</button>`;
            
            errorAlert.innerHTML = errorDetails;
            
            // Insérer l'alerte avant le placeholder
            athletePlaceholder.parentNode.insertBefore(errorAlert, athletePlaceholder);
            
            showAthletePlaceholder();
        });
    }
    
    // Cette fonction est déjà définie plus tôt dans le script
    
    // Fonction pour afficher le placeholder
    function showAthletePlaceholder() {
        athletePlaceholder.style.display = 'flex';
        athleteDetails.style.display = 'none';
        loadingIndicator.style.display = 'none';
    }
    
    // Ces éléments sont déjà définis au début du script
    // Aucun besoin de les redéclarer ici
    
    // Ajouter un exercice à la sélection
    function addExercise(exerciseId) {
        const exerciseItem = document.querySelector(`.exercise-item[data-id="${exerciseId}"]`);
        if (!exerciseItem) return;
        
        // Créer une copie de l'élément pour la liste des sélectionnés
        const clone = exerciseItem.cloneNode(true);
        
        // Remplacer le bouton d'ajout par un bouton de suppression
        const addButton = clone.querySelector('.btn-add-exercise');
        const removeButton = document.createElement('button');
        removeButton.className = 'btn-remove-exercise';
        removeButton.setAttribute('data-id', exerciseId);
        removeButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        `;
        addButton.parentNode.replaceChild(removeButton, addButton);
        
        // Ajouter l'écouteur d'événement pour le bouton de suppression
        removeButton.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            removeExercise(id);
        });
        
        // Masquer l'élément original
        exerciseItem.style.display = 'none';
        
        // Ajouter la copie à la liste des sélectionnés
        selectedList.appendChild(clone);
        
        // Cacher le message "aucun exercice sélectionné"
        emptySelection.style.display = 'none';
        
        // Ajouter l'ID au select caché
        const option = document.createElement('option');
        option.value = exerciseId;
        option.selected = true;
        hiddenSelect.appendChild(option);
        
        // Mettre à jour les compteurs
        updateAvailableCount();
        updateSelectedCount();
    }
    
    // Supprimer un exercice de la sélection
    function removeExercise(exerciseId) {
        // Supprimer l'élément de la liste des sélectionnés
        const selectedItem = selectedList.querySelector(`.exercise-item[data-id="${exerciseId}"]`);
        if (selectedItem) {
            selectedList.removeChild(selectedItem);
        }
        
        // Réafficher l'élément original
        const originalItem = exerciseList.querySelector(`.exercise-item[data-id="${exerciseId}"]`);
        if (originalItem) {
            originalItem.style.display = 'flex';
        }
        
        // Supprimer l'option du select caché
        const option = hiddenSelect.querySelector(`option[value="${exerciseId}"]`);
        if (option) {
            hiddenSelect.removeChild(option);
        }
        
        // Afficher le message "aucun exercice sélectionné" si nécessaire
        if (selectedList.querySelectorAll('.exercise-item').length === 0) {
            emptySelection.style.display = 'flex';
        }
        
        // Mettre à jour les compteurs
        updateAvailableCount();
        updateSelectedCount();
    }
    
    // Ces fonctions sont déjà définies au début du script
    // Aucun besoin de les redéclarer ici
    
    // Ajouter les écouteurs d'événements pour les boutons d'ajout
    exerciseList.addEventListener('click', function(e) {
        if (e.target.closest('.btn-add-exercise')) {
            const button = e.target.closest('.btn-add-exercise');
            const exerciseId = button.getAttribute('data-id');
            addExercise(exerciseId);
        }
    });
    
    // Fonction pour filtrer les exercices par catégorie
    function filterByCategory(category) {
        const items = exerciseList.querySelectorAll('.exercise-item');
        items.forEach(item => {
            // Ne pas filtrer les éléments déjà sélectionnés
            if (selectedList.querySelector(`.exercise-item[data-id="${item.dataset.id}"]`)) {
                item.style.display = 'none';
                return;
            }
            
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
        updateAvailableCount();
    }
    
    // Fonction pour filtrer les exercices par recherche
    function filterBySearch(query) {
        const items = exerciseList.querySelectorAll('.exercise-item');
        const searchTerm = query.toLowerCase();
        
        items.forEach(item => {
            // Ne pas filtrer les éléments déjà sélectionnés
            if (selectedList.querySelector(`.exercise-item[data-id="${item.dataset.id}"]`)) {
                item.style.display = 'none';
                return;
            }
            
            const name = item.querySelector('h5').textContent.toLowerCase();
            const category = item.dataset.category.toLowerCase();
            
            // Vérifier si le nom ou la catégorie contient le terme de recherche
            if (name.includes(searchTerm) || category.includes(searchTerm)) {
                // Vérifier également le filtre de catégorie
                const selectedCategory = categoryFilter.value;
                if (selectedCategory === 'all' || item.dataset.category === selectedCategory) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            } else {
                item.style.display = 'none';
            }
        });
        updateAvailableCount();
    }
    
    // Ajouter l'écouteur d'événement pour le filtre de catégorie
    categoryFilter.addEventListener('change', function() {
        const category = this.value;
        filterByCategory(category);
        
        // Appliquer également la recherche si elle est active
        if (searchInput.value) {
            filterBySearch(searchInput.value);
        }
    });
    
    // Ajouter l'écouteur d'événement pour la recherche
    searchInput.addEventListener('input', function() {
        filterBySearch(this.value);
    });
    
    // Ajouter l'écouteur d'événement pour le bouton de réinitialisation
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        
        // Appliquer uniquement le filtre de catégorie
        const category = categoryFilter.value;
        filterByCategory(category);
    });
    
    // Initialiser le filtre des catégories
    const categories = new Set();
    document.querySelectorAll('.exercise-item').forEach(item => {
        categories.add(item.dataset.category);
    });
    
    // Ajouter les options de catégorie au select
    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        categoryFilter.appendChild(option);
    });
});
</script>
</div>

<style>
.program-creation-section {
    max-width: 1000px;
    margin: 0 auto;
}

.coach-badge {
    display: flex;
    align-items: center;
    background-color: var(--blue-very-pale);
    padding: var(--spacing-sm) var(--spacing-md);
    border-radius: var(--border-radius-sm);
    border-left: 4px solid var(--blue-primary);
}

.coach-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue-primary), var(--blue-light));
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 600;
    margin-right: var(--spacing-md);
}

.coach-info {
    display: flex;
    flex-direction: column;
}

.coach-role {
    font-size: 0.8rem;
    color: var(--blue-primary);
    font-weight: 500;
}

.coach-name {
    font-weight: 600;
    color: var(--blue-dark);
}

.form-container {
    margin-top: var(--spacing-lg);
}

.program-form {
    background-color: var(--white);
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-md);
    border: var(--border-width) solid var(--blue-very-pale);
    overflow: hidden;
}

.form-header {
    background-color: var(--blue-primary);
    color: var(--white);
    padding: var(--spacing-lg);
}

.form-header h2 {
    color: var(--white);
    margin-bottom: var(--spacing-sm);
}

.form-header p {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0;
}

.form-section {
    padding: var(--spacing-lg);
}

.form-divider {
    height: 1px;
    background-color: var(--blue-very-pale);
    margin: 0 var(--spacing-lg);
}

.form-group + .form-group {
    margin-top: var(--spacing-lg);
}

.form-row {
    display: flex;
    gap: var(--spacing-lg);
}

.form-row .form-group {
    flex: 1;
}

.form-label {
    display: block;
    margin-bottom: var(--spacing-sm);
    font-weight: 500;
    color: var(--blue-dark);
}

.form-control,
.form-select {
    width: 100%;
    padding: var(--spacing-md);
    border: var(--border-width) solid var(--blue-pale);
    border-radius: var(--border-radius-sm);
    font-family: inherit;
    font-size: 1rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.form-control:focus,
.form-select:focus {
    outline: none;
    border-color: var(--blue-primary);
    box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.25);
}

.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%230077B6' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right var(--spacing-md) center;
}

.form-select[multiple] {
    height: 200px;
    background-image: none;
    padding: var(--spacing-xs);
}

.form-select[multiple] option {
    padding: var(--spacing-sm);
    border-radius: var(--border-radius-sm);
    margin-bottom: 2px;
}

.form-select[multiple] option:checked {
    background-color: var(--blue-very-pale);
    color: var(--blue-dark);
}

.form-hint {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: var(--spacing-xs);
}

.form-error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: var(--spacing-xs);
}

.btn-clicked {
    background-color: #ff9900 !important;
    transform: scale(1.1);
    transition: all 0.3s ease;
}

.exercise-selection {
    border: var(--border-width) solid var(--blue-pale);
    border-radius: var(--border-radius-sm);
    overflow: hidden;
}

.exercise-selection select {
    border: none;
    outline: none;
}

.form-actions {
    padding: var(--spacing-lg);
    background-color: var(--blue-very-pale);
    display: flex;
    justify-content: flex-end;
    gap: var(--spacing-md);
}

/* Styles pour les détails de l'athlète */
.athlete-details {
    background-color: var(--white);
    border-radius: var(--border-radius-md);
    box-shadow: var(--shadow-md);
    padding: var(--spacing-lg);
    border: var(--border-width-thin) solid var(--blue-very-pale);
}

.athlete-header {
    display: flex;
    align-items: center;
    margin-bottom: var(--spacing-lg);
}

.athlete-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue-primary), var(--blue-secondary));
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: var(--font-weight-bold);
    margin-right: var(--spacing-lg);
    box-shadow: var(--shadow-sm);
}

.athlete-identity h3 {
    color: var(--blue-dark);
    margin-bottom: var(--spacing-xs);
    font-size: var(--font-size-lg);
}

.athlete-email {
    color: var(--dark-gray);
    font-size: var(--font-size-sm);
}

.athlete-stats {
    display: flex;
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
}

.stat-card {
    background-color: var(--blue-very-pale);
    border-radius: var(--border-radius-md);
    padding: var(--spacing-md);
    flex: 1;
    min-width: 100px;
}

.stat-number {
    font-size: 2rem;
    font-weight: var(--font-weight-bold);
    color: var(--blue-primary);
    margin-bottom: var(--spacing-xs);
}

.stat-label {
    color: var(--blue-dark);
    font-weight: var(--font-weight-medium);
}

.stat-header {
    color: var(--blue-dark);
    font-weight: var(--font-weight-medium);
    margin-bottom: var(--spacing-sm);
    font-size: var(--font-size-sm);
}

.stat-program-name {
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--spacing-xxs);
    color: var(--blue-primary);
}

.stat-program-date {
    font-size: var(--font-size-xs);
    color: var(--dark-gray);
}

.athlete-actions {
    display: flex;
    justify-content: flex-end;
}

.loading-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-xl);
    color: var(--blue-primary);
}

.loading-indicator svg {
    margin-bottom: var(--spacing-md);
}

.loading-indicator span {
    color: var(--blue-dark);
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.spin {
    animation: spin 1.5s linear infinite;
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: var(--spacing-md);
    }
    
    .program-header {
        flex-direction: column;
        gap: var(--spacing-md);
    }
    
    .coach-badge {
        align-self: flex-start;
    }
    
    .athlete-stats {
        flex-direction: column;
    }
}
</style>
@endsection