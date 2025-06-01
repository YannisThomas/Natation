# Aquafit Design System

Ce document décrit le système de design utilisé pour l'application Aquafit, incluant la palette de couleurs, les composants, et les directives de style.

## Palette de couleurs

La palette de couleurs utilise des dégradés de bleu pour créer une hiérarchie visuelle cohérente:

- `--blue-dark: #03045E` - Utilisé pour les textes importants et accents forts
- `--blue-secondary: #023E8A` - Utilisé pour les états hover des éléments primaires
- `--blue-primary: #0077B6` - Couleur principale pour les boutons et éléments interactifs
- `--blue-medium: #0096C7` - Utilisé pour les accents secondaires
- `--blue-light: #00B4D8` - Utilisé pour les accents légers et les gradients
- `--blue-lighter: #48CAE4` - Utilisé pour les arrière-plans légers et indicateurs
- `--blue-pale: #90E0EF` - Utilisé pour les bordures et séparateurs
- `--blue-very-pale: #ADE8F4` - Utilisé pour les arrière-plans de sections
- `--blue-background: #CAF0F8` - Couleur de fond principale de l'application

## Typographie

- Titres: Montserrat (gras)
- Corps de texte: Poppins (normal)
- Hiérarchie des tailles:
  - h1: 2.5rem
  - h2: 2rem
  - h3: 1.5rem
  - Texte standard: 1rem

## Composants

### Cartes

Les cartes sont utilisées pour afficher des informations structurées (programmes, athlètes, etc.):
- Arrière-plan blanc
- Bordure légère (`var(--blue-very-pale)`)
- Ombre portée (`var(--shadow-md)`)
- Coins arrondis (`var(--border-radius-md)`)
- Effet de survol avec élévation et ombre accentuée

### Boutons

- **Bouton primaire**: Fond `var(--blue-primary)`, texte blanc
- **Bouton secondaire**: Fond blanc, bordure `var(--blue-primary)`, texte `var(--blue-primary)`
- Tous les boutons ont:
  - Coins arrondis (`var(--border-radius-sm)`)
  - Padding consistant
  - Effet de survol (changement de couleur)

### Formulaires

- Champs avec bordure légère (`var(--blue-pale)`)
- Focus avec bordure `var(--blue-primary)` et ombre spécifique
- Labels en gras, couleur `var(--blue-dark)`
- Messages d'aide en gris plus petit
- Messages d'erreur en rouge

### Navigation

- Liens avec effet de survol
- Élément actif marqué en `var(--blue-primary)` avec texte blanc
- Menu déroulant pour l'utilisateur connecté

## Espacement

Système d'espacement cohérent:
- `--spacing-xs: 0.25rem`
- `--spacing-sm: 0.5rem`
- `--spacing-md: 1rem`
- `--spacing-lg: 1.5rem`
- `--spacing-xl: 2rem`
- `--spacing-xxl: 3rem`

## Bordures et ombres

- Bordures fines (`var(--border-width)`) avec couleurs appropriées
- Ombres pour la profondeur:
  - `--shadow-sm`: Ombre légère
  - `--shadow-md`: Ombre moyenne (utilisée par défaut)
  - `--shadow-lg`: Ombre prononcée (survol)

## Responsive Design

- Utilisation de Flexbox et Grid pour les layouts
- Points de rupture à 768px pour adapter l'affichage sur mobile
- Elements qui passent en colonne sur petits écrans
- Taille de police adaptative

## États et indicateurs

- Indicateurs de statut (triangle en haut à droite des cartes)
- Barres de progression pour suivre l'avancement
- Avatars générés à partir des initiales des utilisateurs
- Badges pour les informations importantes

## Implémentation

Le système est implémenté via un fichier CSS principal (`aquafit.css`) qui définit toutes les variables et styles de base. Chaque page peut aussi inclure des styles spécifiques pour des besoins particuliers.