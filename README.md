

# Bahjawa Medical Center

Application web de gestion d'un cabinet médical développée avec Laravel 13, PHP 8.4, MySQL, Tailwind CSS et DomPDF.

## Lien de l'application déployée

https://medical-center-bahjawi.up.railway.app

## Fonctionnalités

- Authentification multi-rôles (Admin, Médecin, Secrétaire, Patient)
- Gestion des utilisateurs (CRUD complet)
- Gestion des rendez-vous avec statuts (en attente, confirmé, annulé)
- Gestion des consultations médicales
- Génération de prescriptions/ordonnances en PDF
- Gestion des disponibilités des médecins
- Notifications email (Mailtrap en environnement local)
- Dashboard avec statistiques pour chaque rôle
- Espace patient avec historique et prise de rendez-vous
- Export PDF des ordonnances avec DomPDF

## Stack technique

- Backend : Laravel 13.5, PHP 8.4
- Base de données : MySQL
- Frontend : Tailwind CSS, Blade Templates
- PDF : barryvdh/laravel-dompdf
- Email : Mailtrap (SMTP sandbox)
- Déploiement : Railway (Docker)
- Versioning : Git / GitHub

## Installation locale

```bash
git clone https://github.com/samidos03/medical-center-.git
cd medical-center-
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
```

Configurer le fichier .env avec les informations de base de données MySQL puis :

```bash
php artisan migrate --seed
php artisan serve
```

Ouvrir http://127.0.0.1:8000

## Comptes de démonstration

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| Admin | admin@cabinet.ma | password |
| Médecin | medecin1@cabinet.ma | password |
| Secrétaire | secretaire@cabinet.ma | password |
| Patient | patient1@cabinet.ma | password |

## Structure de la base de données

- users : utilisateurs avec rôles
- medecins : profils médecins liés aux spécialités
- patients : profils patients avec informations médicales
- specialites : spécialités médicales
- rendezvouses : rendez-vous entre patients et médecins
- consultations : consultations médicales
- ordonnances : prescriptions médicales
- disponibilites : créneaux horaires des médecins

## Seeders

Les seeders se trouvent dans database/seeders/ et créent les données de démonstration :

- UserSeeder : 10 utilisateurs (1 admin, 3 médecins, 1 secrétaire, 5 patients)
- MedecinSeeder : profils médecins avec spécialités
- PatientSeeder : profils patients avec informations médicales
- RendezvousSeeder : rendez-vous de démonstration

## Tests unitaires

37 tests PHPUnit couvrant :

- Authentification (login, logout, register, forgot password)
- Gestion des rendez-vous (création, confirmation, annulation)
- Gestion des consultations et ordonnances
- Gestion des patients (CRUD, relations, autorisations)
- Modèles et relations Eloquent

Lancer les tests :

```bash
php artisan test
```

## Déploiement

Le projet est déployé sur Railway avec Docker. Le Dockerfile utilise PHP 8.4-cli avec le serveur PHP intégré.

## Auteur

Oussama Samid - PFE 2025/2026


SAMID Oussama
FARAH Mariam
DOUBABI Ali
ECHCHAFIAI Aicha

2025-2026