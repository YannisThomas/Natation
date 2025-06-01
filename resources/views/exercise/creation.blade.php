@extends('layouts.base')
@section('title', 'Création d\'un exercice - Aquafit')
@section('content')

<div class="exercise-creation-container">
    <div class="page-header">
        <div class="page-title-section">
            <h1>Créer un nouvel exercice</h1>
            <p class="page-description">Remplissez le formulaire ci-dessous pour créer un nouvel exercice qui pourra être utilisé dans vos programmes d'entraînement.</p>
        </div>
        
        <div class="actions-container">
            <a href="{{ url('/exercice/liste') }}" class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="alert-content">
                <h4>Erreur lors de la création de l'exercice</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    
    <div class="form-card">
        <div class="form-header">
            <h2>Informations de l'exercice</h2>
            <p>Les champs marqués d'un astérisque (*) sont obligatoires</p>
        </div>
        
        <form method="POST" action="/exercice/creation" class="creation-form">
            @csrf
            
            <div class="form-content">
                <div class="form-section">
                    <h3 class="section-title">Informations générales</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label required">Nom de l'exercice</label>
                            <input id="name" type="text" name="name" class="form-control" placeholder="Ex: Nage papillon" value="{{ old('name') }}" required />
                            @error('name')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                            <div class="form-hint">Donnez un nom clair et descriptif à votre exercice</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_id" class="form-label required">Catégorie</label>
                            <select id="category_id" name="category_id" class="form-select" required>
                                <option value="">-- Sélectionnez une catégorie --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Décrivez l'exercice, les technique à adopter, les conseils d'exécution..." rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-divider"></div>
                
                <div class="form-section">
                    <h3 class="section-title">Paramètres de l'exercice</h3>
                    <p class="section-description">Renseignez les paramètres applicables à cet exercice. Vous pouvez laisser vides ceux qui ne s'appliquent pas.</p>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="duration" class="form-label">Durée (minutes)</label>
                            <div class="input-group">
                                <input id="duration" type="number" name="duration" class="form-control" placeholder="Ex: 30" value="{{ old('duration') }}" min="0" />
                                <span class="input-group-text">min</span>
                            </div>
                            @error('duration')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="distance" class="form-label">Distance (mètres)</label>
                            <div class="input-group">
                                <input id="distance" type="number" name="distance" class="form-control" placeholder="Ex: 200" value="{{ old('distance') }}" min="0" />
                                <span class="input-group-text">m</span>
                            </div>
                            @error('distance')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="repetition" class="form-label">Répétitions</label>
                            <input id="repetition" type="number" name="repetition" class="form-control" placeholder="Ex: 10" value="{{ old('repetition') }}" min="0" />
                            @error('repetition')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="weight" class="form-label">Poids (kg)</label>
                            <div class="input-group">
                                <input id="weight" type="number" name="weight" class="form-control" placeholder="Ex: 5" value="{{ old('weight') }}" min="0" step="0.1" />
                                <span class="input-group-text">kg</span>
                            </div>
                            @error('weight')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="type" class="form-label">Type d'exercice</label>
                        <select id="type" name="type" class="form-select">
                            <option value="">-- Sélectionner un type --</option>
                            <option value="Échauffement" {{ old('type') == 'Échauffement' ? 'selected' : '' }}>Échauffement</option>
                            <option value="Endurance" {{ old('type') == 'Endurance' ? 'selected' : '' }}>Endurance</option>
                            <option value="Force" {{ old('type') == 'Force' ? 'selected' : '' }}>Force</option>
                            <option value="Vitesse" {{ old('type') == 'Vitesse' ? 'selected' : '' }}>Vitesse</option>
                            <option value="Technique" {{ old('type') == 'Technique' ? 'selected' : '' }}>Technique</option>
                            <option value="Récupération" {{ old('type') == 'Récupération' ? 'selected' : '' }}>Récupération</option>
                        </select>
                        @error('type')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="{{ url('/exercice/liste') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Créer l'exercice
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .exercise-creation-container {
        max-width: 900px;
        margin: 0 auto;
        padding: var(--spacing-md);
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: var(--spacing-xl);
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
    
    .form-card {
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: var(--border-width-thin) solid var(--blue-very-pale);
    }
    
    .form-header {
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-medium));
        color: var(--white);
        padding: var(--spacing-lg);
    }
    
    .form-header h2 {
        color: var(--white);
        margin-bottom: var(--spacing-xs);
    }
    
    .form-header p {
        color: rgba(255, 255, 255, 0.8);
        font-size: var(--font-size-sm);
    }
    
    .form-content {
        padding: var(--spacing-lg);
    }
    
    .form-section {
        margin-bottom: var(--spacing-xl);
    }
    
    .section-title {
        font-size: var(--font-size-lg);
        color: var(--blue-dark);
        margin-bottom: var(--spacing-md);
        padding-bottom: var(--spacing-xs);
        border-bottom: var(--border-width-thin) solid var(--blue-very-pale);
    }
    
    .section-description {
        color: var(--dark-gray);
        margin-bottom: var(--spacing-md);
        font-size: var(--font-size-sm);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
    }
    
    .form-divider {
        height: 1px;
        background-color: var(--blue-very-pale);
        margin: var(--spacing-xl) 0;
    }
    
    .form-label.required::after {
        content: ' *';
        color: var(--danger);
    }
    
    .alert {
        display: flex;
        gap: var(--spacing-md);
        padding: var(--spacing-md) var(--spacing-lg);
        border-radius: var(--border-radius-md);
        margin-bottom: var(--spacing-xl);
    }
    
    .alert-danger {
        background-color: var(--danger-light);
        border-left: 4px solid var(--danger);
        color: #842029;
    }
    
    .alert-icon {
        color: var(--danger);
        flex-shrink: 0;
    }
    
    .alert-content h4 {
        color: #842029;
        margin-bottom: var(--spacing-xs);
    }
    
    .alert-content ul {
        margin-bottom: 0;
        padding-left: var(--spacing-lg);
    }
    
    .input-group {
        display: flex;
    }
    
    .input-group-text {
        display: flex;
        align-items: center;
        padding: 0 var(--spacing-md);
        background-color: var(--blue-very-pale);
        border: var(--border-width-thin) solid var(--blue-pale);
        border-left: none;
        border-top-right-radius: var(--border-radius-md);
        border-bottom-right-radius: var(--border-radius-md);
        color: var(--blue-dark);
    }
    
    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    
    .form-actions {
        padding: var(--spacing-lg);
        background-color: var(--blue-very-pale);
        display: flex;
        justify-content: flex-end;
        gap: var(--spacing-md);
        border-top: var(--border-width-thin) solid var(--blue-pale);
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: var(--spacing-md);
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: var(--spacing-md);
        }
    }
</style>
@endsection
