# Prompt pour refonte UI d'Aquafit

Voici le prompt à utiliser pour continuer le travail sur d'autres conversations:

```
Je souhaite refaire l'UI de mon application web de natation "Aquafit" en utilisant la palette de couleurs suivante: 03045E, 023E8A, 0077B6, 0096C7, 00B4D8, 48CAE4, 90E0EF, ADE8F4, CAF0F8.

Je recherche un design à la fois sobre et attrayant, avec:
- Une séparation claire des éléments via des bordures et effets subtils
- Des composants bien structurés (cartes, boutons, formulaires)
- Une interface responsive et moderne
- Une hiérarchie visuelle claire grâce aux différentes nuances de bleu
- Des espaces consistants pour une meilleure lisibilité
- Des effets d'interaction subtils (hover, focus, etc.)

Mon application est une plateforme de gestion d'entraînements de natation, permettant aux coachs de créer des programmes pour leurs athlètes et aux athlètes de suivre leur progression.

Caractéristiques principales:
- Système d'authentification (admin, coach, athlète)
- Gestion des programmes d'entraînement
- Suivi des exercices et de leur complétion
- Relations coach-athlète

J'ai déjà un fichier CSS principal nommé aquafit.css qui définit les variables et composants de base. J'ai besoin de refondre les pages suivantes (indiquer les pages spécifiques).

Merci de me montrer comment implémenter cette nouvelle direction artistique dans mes templates Laravel Blade existants.
```

## Pages à traiter

Voici les pages qu'il reste à moderniser:

1. **Détail des exercices (`program/voirprog.blade.php`)**
   - Affiche les exercices spécifiques d'un programme
   - Besoin d'une mise en page claire et d'indicateurs de progression

2. **Liste des exercices (`exercise/voir.blade.php`)**
   - Affiche tous les exercices disponibles
   - Possibilité de filtrage et recherche

3. **Création d'exercice (`exercise/creation.blade.php`)**
   - Formulaire pour créer de nouveaux exercices
   - Champs pour nom, description, durée, etc.

4. **Édition de profil (`profile/edit.blade.php`)**
   - Page de modification des informations utilisateur
   - Formulaires pour informations personnelles, mot de passe, etc.

5. **Pages d'authentification**
   - Login, Register, Reset Password, etc.
   - Style cohérent avec le reste de l'application

## Instructions d'implémentation

1. Utilisez le fichier `aquafit.css` comme base
2. Adaptez chaque page en utilisant les classes et variables CSS définies
3. Assurez-vous que toutes les pages sont responsives
4. Maintenez la cohérence visuelle à travers toute l'application