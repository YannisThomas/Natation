# NOTE POUR LES EXAMINATEURS : Mot de passe de la session ubuntu : btssio2025
les différents mots de passes pour tester les fonctions des différents utilisateurs sont situés dans le document texte sur le bureau
# Projet Natation-3

## Description

Natation-3 est une application web construite avec le framework Laravel, conçue pour fournir des fonctionnalités liées à la natation.

## Fonctionnalités

- Inscription et Authentification des Utilisateurs
- Design Responsive
- Fonctionnalités Puissantes de Laravel :
  - Système de Routage
  - Injection de Dépendances
  - ORM Eloquent
  - Migrations de Base de Données
  - Traitement de Tâches en Arrière-plan

## Prérequis

- PHP 8.1+
- Composer
- Node.js
- MySQL ou PostgreSQL

## Installation

1. Cloner le dépôt
```bash
git clone https://github.com/votrenom/natation-3.git

```


2. Installer les dépendendances PHP avec Composer :
```bash
composer install

```
3. Installer les dépendances JavaScript avec npm :
```bash
npm install
```

4. Copier le fichier d'environnement et configurer :
```bash
cp .env.example .env
php artisan key:generate
```
5. Configurer la base de données et executer les migrations :
```bash
php artisan migrate
```
## Lancement de l'application
```bash
php artisan serve
npm run dev
```



## Tests
```bash
php "-dxdebug.mode=coverage" .\vendor\phpunit\phpunit\phpunit --coverage-html .\documents\phpunit
```
