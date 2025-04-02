# Projet Client Léger (Natation)

Ce projet est une plateforme web destinée aux **sportifs professionnels en natation** ainsi qu’à leurs **coachings encadrants**, gérée par des administrateurs via un tableau de bord sécurisé.

---

## 🚀 Objectif du projet

Offrir un outil en ligne simple et fonctionnel pour :
- Permettre aux **coach** de gérer les sportifs affiliés
- Suivre et créer des **programmes d’entraînement personnalisés**
- Administrer la **base d’utilisateurs** via des rôles hiérarchisés

---

## 👥 Rôles utilisateurs

| Rôle         | Description |
|--------------|-------------|
| **Super Admin** | Gère tous les utilisateurs, peut créer, modifier ou supprimer n’importe quel utilisateur |
| **Admin**       | Peut gérer les affiliations coach ↔ sportif |
| **Coach**       | Accède à ses sportifs affiliés, peut créer/éditer leurs programmes |
| **Sportif**     | Consulte ses programmes d'entraînement |

---

## ⚙️ Fonctionnalités principales

- Authentification sécurisée avec vérification email
- Dashboard personnalisé selon le rôle
- Création, édition et suppression d'utilisateurs (superadmin)
- Création de programmes d'entraînement (coach)
- Système d’affiliation entre coach et sportif (admin/superadmin)
- Filtres utilisateurs par rôle

---

## 🛠️ Stack technique

- **Laravel 10+** (backend + auth)
- **Blade** (moteur de template)
- **CSS personnalisé** (responsive design, charte respectée)
- **MySQL** (base de données relationnelle)

---

## 🖼️ Aperçu visuel

> Ajouter ici des captures d’écran :
- Dashboard superadmin
- Formulaire de création d’utilisateur
- Page coach avec programmes
- Page sportif avec consultation des programmes

---

## 📂 Structure simplifiée

```
/app
    /Http/Controllers
    /Models
/resources
    /views
    /css
/routes
    web.php
/public
    /images
    /css
```

---

## 📋 Installation rapide

```bash
git clone https://github.com/ton-repo/projet-natation.git
cd projet-natation

composer install
cp .env.example .env
php artisan key:generate

# configure .env (DB + mail...)

php artisan migrate --seed
php artisan serve
```

---

## 📦 Données utiles (seeding initial)

- Rôles déjà en base :
  - 1 = superadmin
  - 2 = admin
  - 3 = coach
  - 4 = sportif

---

## 🎨 Charte Graphique

> Voir le fichier `charte-graphique.pdf` joint pour le détail des couleurs, typographie et design UI.

---

## 👨‍💻 Auteur

Développé par [TonNom], dans le cadre d’un projet client encadré.

---

## ✅ Dernier push : Projet finalisé et fonctionnel 💯
