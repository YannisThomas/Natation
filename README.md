# Aquafit - Système de Gestion d'Entraînements de Natation

> **NOTE POUR LES EXAMINATEURS :** Les différents mots de passe pour tester les fonctions des différents utilisateurs sont disponibles dans la documentation ci-dessous.

> **⚠️ IMPORTANT : Le mot de passe de la session Ubuntu est : `btssio2025`**

## 📋 Table des Matières

- [Vue d'ensemble](#vue-densemble)
- [Technologies](#technologies)
- [Architecture](#architecture)
- [Fonctionnalités](#fonctionnalités)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [API REST](#api-rest)
- [Tests](#tests)
- [Déploiement](#déploiement)
- [Développement](#développement)

## 🌊 Vue d'ensemble

**Aquafit** est une application web moderne développée avec Laravel pour la gestion d'entraînements de natation. Elle permet aux coachs de créer des programmes personnalisés pour leurs athlètes, incluant des exercices praticables en piscine et hors bassins, répondant ainsi aux besoins d'entraînement continu selon l'annexe 9-1-B du BTS SIO 2025.

### Objectif Principal
Permettre aux nageurs de s'entraîner efficacement même en dehors des piscines, avec un suivi complet de leur progression via une interface web intuitive et une API mobile complète.

## 💻 Technologies

### Backend
- **Laravel 11.9** - Framework PHP moderne
- **PHP 8.2+** - Langage serveur
- **SQLite** (développement) / **MySQL/PostgreSQL** (production)
- **Laravel Sanctum** - Authentification API
- **Swagger/OpenAPI** - Documentation API

### Frontend
- **Blade Templates** - Moteur de template Laravel
- **Tailwind CSS** - Framework CSS utilitaire
- **Alpine.js** - Framework JavaScript léger
- **Vite** - Build tool moderne

### Outils de Développement
- **PHPUnit** - Tests unitaires et d'intégration
- **Laravel Pint** - Formateur de code PSR-12
- **Composer** - Gestionnaire de dépendances PHP
- **NPM** - Gestionnaire de dépendances JavaScript

## 🏗️ Architecture

### Structure MVC Laravel

```
app/
├── Console/Commands/          # Commandes Artisan personnalisées
├── Http/
│   ├── Controllers/          # Contrôleurs web
│   │   ├── Api/             # Contrôleurs API REST
│   │   ├── Auth/            # Authentification Laravel Breeze
│   │   ├── AthleteController.php
│   │   ├── ExerciseController.php
│   │   ├── ProgramController.php
│   │   └── UserController.php
│   ├── Middleware/          # Middlewares personnalisés
│   │   ├── AdminMiddleware.php
│   │   ├── CoachMiddleware.php
│   │   └── AthleteMiddleware.php
│   └── Requests/            # Form Requests pour validation
├── Models/                  # Modèles Eloquent
│   ├── User.php
│   ├── Exercise.php
│   ├── Program.php
│   ├── Category.php
│   └── Role.php
└── Providers/              # Service Providers
```

### Base de Données

**6 tables principales :**

1. **users** - Utilisateurs (admin, coach, athlète)
2. **roles** - Système de rôles avec permissions
3. **exercises** - Exercices avec paramètres (durée, distance, poids, répétitions)
4. **categories** - Catégories d'exercices (Crawl, Brasse, Dos, Papillon, Renforcement, Endurance, Hors Piscine)
5. **programs** - Programmes d'entraînement avec coach et athlète assignés
6. **exercise_program** - Table pivot avec données de performance et tracking GPS

### Relations Principales
- User `belongsTo` Role
- Program `belongsTo` User (athlète) et Coach (User)
- Exercise `belongsToMany` Program (avec données pivot enrichies)
- Exercise `belongsTo` Category

## ⚡ Fonctionnalités

### 🔐 Système d'Authentification
- **3 rôles** : Admin, Coach, Athlète
- **Permissions granulaires** avec middlewares spécialisés
- **Authentification web** : Laravel Breeze
- **Authentification API** : Laravel Sanctum

### 👥 Gestion des Utilisateurs
- **Inscription sécurisée** avec validation
- **Profils personnalisés** par rôle
- **Relations coach-athlète** gérées automatiquement

### 🏊‍♂️ Gestion des Exercices
- **30+ exercices prédéfinis** incluant exercices hors piscine
- **Catégorisation complète** : 7 catégories avec exercices spécialisés
- **Paramètres configurables** : durée, distance, poids, répétitions
- **CRUD complet** pour coachs et admins
- **Recherche et filtres** avancés

### 📋 Programmes d'Entraînement
- **Création personnalisée** par les coachs
- **Attribution aux athlètes** avec suivi
- **Progression en temps réel** basée sur les exercices terminés
- **Validation d'exercices** : interface web + API mobile
- **Historique complet** des programmes

### 📱 API REST Complète
- **9 endpoints** documentés avec Swagger
- **Validation d'exercices** avec données de performance
- **Support GPS** pour exercices hors piscine
- **Données biométriques** : fréquence cardiaque, calories
- **Authentification sécurisée**

### 🎨 Interface Utilisateur
- **Design system cohérent** : 9 nuances de bleu Aquafit
- **Responsive design** mobile-first
- **Animations fluides** et feedback visuel
- **Navigation contextuelle** adaptée par rôle
- **Tableaux de bord personnalisés**

## 🚀 Installation

### Prérequis
- **PHP 8.2+** avec extensions : mysqli, pdo, openssl, mbstring, tokenizer, xml, ctype, json, bcmath
- **Composer 2.0+**
- **Node.js 18+** et NPM
- **Git**
- **Serveur web** (Apache/Nginx) pour production

### Installation Complète

```bash
# 1. Cloner le repository
git clone https://github.com/YannisThomas/Natation.git
cd Natation

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JavaScript
npm install

# 4. Configuration environnement
cp .env.example .env
php artisan key:generate

# 5. Configuration base de données (SQLite par défaut)
touch database/database.sqlite

# 6. Exécuter les migrations et seeders
php artisan migrate --seed

# 7. Compiler les assets
npm run build

# 8. Générer la documentation API
php artisan l5-swagger:generate

# 9. Configurer les permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Serveur de Développement

```bash
# Démarrer le serveur Laravel
php artisan serve

# En parallèle, pour le développement frontend
npm run dev

# Application disponible sur : http://localhost:8000
```

## ⚙️ Configuration

### Variables d'Environnement (.env)

```env
APP_NAME=Aquafit
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de données SQLite (développement)
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite

# Ou MySQL (production)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aquafit
DB_USERNAME=root
DB_PASSWORD=

# Mail (pour réinitialisation mots de passe)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

### Configuration Production

```bash
# Optimisations Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Variables d'environnement sécurisées
APP_ENV=production
APP_DEBUG=false
```

## 📖 Utilisation

### Comptes de Test Prêts

| Rôle | Email | Mot de passe | Description |
|------|--------|--------------|-------------|
| **Admin** | `admin@mail.com` | `test1234` | Accès complet |
| **Admin Exam** | `examiner.admin@test.com` | `examiner123` | Compte évaluateur admin |
| **Coach Exam** | `examiner.coach@test.com` | `examiner123` | Compte évaluateur coach |
| **Athlète Exam** | `examiner.athlete@test.com` | `examiner123` | Compte évaluateur athlète |

### Workflows par Utilisateur

#### 👨‍💼 Workflow Admin
1. **Connexion** → Dashboard admin complet
2. **Gestion utilisateurs** → Voir tous les utilisateurs
3. **Gestion exercices** → CRUD complet sur tous les exercices
4. **Gestion programmes** → Voir et modifier tous les programmes
5. **Validation exercices** → Peut valider tous les exercices

#### 🏃‍♂️ Workflow Coach
1. **Connexion** → Dashboard coach
2. **Création exercices** → Ajouter nouveaux exercices à la bibliothèque
3. **Gestion athlètes** → Voir ses athlètes assignés
4. **Création programmes** → Créer programmes personnalisés
5. **Suivi progression** → Monitoring de ses athlètes

#### 🏊‍♀️ Workflow Athlète
1. **Connexion** → Dashboard athlète
2. **Mes programmes** → Voir programmes assignés
3. **Détail programme** → Consulter exercices et progression
4. **Validation exercices** → Marquer exercices comme terminés
5. **Suivi personnel** → Voir sa progression globale

### Navigation Principale

```
├── 🏠 Accueil (Dashboard personnalisé)
├── 🏊‍♂️ Exercices
│   ├── Voir exercices (tous)
│   └── Créer exercice (coach/admin)
├── 📋 Programmes
│   ├── Voir programmes
│   ├── Mes programmes (coach)
│   ├── Mes entraînements (athlète)
│   ├── Créer programme (coach)
│   └── Gestion athlètes (coach)
├── 👤 Profil
│   └── Modifier informations
└── 🔧 Administration (admin)
    └── Gestion complète
```

## 🔌 API REST

### Endpoints Disponibles

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| `GET` | `/api/athlete/{id}` | Détails d'un athlète |
| `GET` | `/api/athlete/{id}/programmes` | Programmes d'un athlète |
| `GET` | `/api/programme/{id}` | Détails d'un programme |
| `PUT` | `/api/programme/{programId}/exercice/{exerciseId}` | Valider un exercice |
| `POST` | `/api/post-exercice` | Soumettre exercice (legacy) |
| `POST` | `/api/performance/record` | Enregistrer performance mobile |

### Documentation API
**Swagger disponible sur :** `http://localhost:8000/api/documentation`

### Exemples d'Utilisation

#### Validation d'Exercice
```bash
curl -X PUT "http://localhost:8000/api/programme/1/exercice/1" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "duration_completed": 1800,
    "distance_completed": 2000.5,
    "repetitions_completed": 40,
    "notes": "Exercice hors piscine terminé",
    "gps_data": [
      {
        "latitude": 48.856614,
        "longitude": 2.352222,
        "timestamp": "2024-01-01T12:00:00Z",
        "speed": 12.5
      }
    ]
  }'
```

#### Enregistrement Performance Mobile
```bash
curl -X POST "http://localhost:8000/api/performance/record" \
  -H "Content-Type: application/json" \
  -d '{
    "athlete_id": 1,
    "exercise_id": 2,
    "program_id": 1,
    "heart_rate": 155,
    "calories": 320,
    "gps_data": [...]
  }'
```

## 🧪 Tests

### Types de Tests Disponibles
- **Tests Feature** : Workflows complets utilisateur
- **Tests Unit** : Modèles et méthodes individuelles
- **Tests API** : Endpoints REST avec authentification

### Exécution des Tests

```bash
# Tous les tests
php artisan test

# Tests spécifiques
php artisan test --filter=ExerciseTest
php artisan test tests/Feature/Auth/

# Avec couverture de code
php artisan test --coverage-html documents/phpunit
```

### Tests Principaux Implémentés
- **Authentification** : Login, registration, permissions
- **Exercices** : CRUD, validation, permissions
- **Programmes** : Création, assignation, progression
- **API** : Validation exercices, enregistrement performances

## 🌐 Déploiement

### Configuration Apache

```apache
<VirtualHost *:80>
    ServerName aquafit.local
    DocumentRoot /var/www/aquafit/public
    
    <Directory /var/www/aquafit/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/aquafit_error.log
    CustomLog ${APACHE_LOG_DIR}/aquafit_access.log combined
</VirtualHost>
```

### HTTPS avec Let's Encrypt
```bash
certbot --apache -d aquafit.votredomaine.com
```

### Script de Déploiement

```bash
#!/bin/bash
# deploy.sh

# Mise à jour code
git pull origin main

# Dépendances
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Laravel optimisations
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "Déploiement terminé !"
```

## 👨‍💻 Développement

### Standards de Code
- **PSR-12** : Standard de codage PHP
- **Laravel Best Practices** : Conventions framework
- **Naming Conventions** : PascalCase classes, camelCase méthodes

### Commandes Utiles

```bash
# Formatage automatique du code
./vendor/bin/pint

# Génération de classes
php artisan make:controller ExampleController
php artisan make:model Example -m
php artisan make:request ExampleRequest

# Base de données
php artisan migrate:fresh --seed
php artisan db:seed --class=SpecificSeeder

# Cache et optimisations
php artisan optimize:clear
php artisan cache:clear
```

### Structure des Fichiers

```
├── 📁 app/                    # Code application
├── 📁 database/              # Migrations, seeders, factories
├── 📁 public/                # Assets publics, point d'entrée
├── 📁 resources/             # Vues, CSS, JS sources
├── 📁 routes/                # Définition des routes
├── 📁 storage/               # Stockage, logs, cache
├── 📁 tests/                 # Tests unitaires et fonctionnels
├── 🔧 .env.example          # Template configuration
├── 📋 composer.json         # Dépendances PHP
├── 📋 package.json          # Dépendances JavaScript
├── 🛠️ vite.config.js        # Configuration build frontend
└── 📖 README.md             # Cette documentation
```

### Extensions VSCode Recommandées
- **Laravel Extension Pack**
- **PHP Intelephense**
- **Tailwind CSS IntelliSense**
- **Laravel Blade Snippets**

## 📈 Fonctionnalités Avancées

### Design System Aquafit
```css
/* Palette de couleurs cohérente */
:root {
    --blue-darkest: #03045E;      /* Navigation, titres */
    --blue-dark: #023E8A;         /* Texte principal */
    --blue-primary: #0077B6;      /* Boutons primaires */
    --blue-medium: #0096C7;       /* Liens, accents */
    --blue-light: #00B4D8;        /* Hover states */
    --blue-lighter: #48CAE4;      /* Backgrounds légers */
    --blue-pale: #90E0EF;         /* Borders subtiles */
    --blue-very-pale: #ADE8F4;    /* Backgrounds très légers */
    --blue-accent: #CAF0F8;       /* Highlights */
}
```

### Exercices Hors Piscine (Conformité Annexe 9-1-B)
- **Course d'endurance** avec tracking GPS
- **Renforcement musculaire** spécialisé nageurs
- **Exercices respiratoires** et apnée
- **Yoga aquatique** et mobilité
- **Préparation mentale** et visualisation

### Validation d'Exercices Intelligente
- **Interface web** avec feedback visuel immédiat
- **API mobile** avec données biométriques complètes
- **Progression temps réel** sans rechargement de page
- **Animations fluides** et UX moderne

## 🔧 Maintenance

### Commandes de Maintenance

```bash
# Nettoyage logs
php artisan log:clear

# Optimisation base de données
php artisan optimize:clear && php artisan optimize

# Mise à jour dépendances
composer update
npm update

# Sauvegarde base de données
php artisan backup:run
```

### Monitoring et Logs
- **Laravel Logs** : `storage/logs/laravel.log`
- **API Logs** : Tracking des requêtes et erreurs
- **Performance** : Monitoring temps de réponse

## 📄 Licence et Crédits

**Développé par :** Thomas Yannis  
**Cadre :** BTS SIO Option SLAM - Session 2025  
**Établissement :** AFTEC Rennes  
**Objectif :** Épreuve E6 - Conception et développement d'applications

### Conformité Annexe 9-1-B
Ce projet répond parfaitement aux exigences de l'annexe 9-1-B :
- ✅ Application web fonctionnelle pour gestion programmes
- ✅ Interface adaptée coachs et sportifs
- ✅ Système permettant entraînement hors piscines
- ✅ Documentation technique fonctionnelle
- ✅ Enregistrement performances via interface intuitive
- ✅ API mobile pour appareils personnels

---

**🌊 Aquafit - Transformez votre entraînement de natation** 🌊

*Pour toute question ou assistance, consultez la documentation technique ou les logs d'application.*