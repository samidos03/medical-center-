 # 🏥 Bahjawa Medical Center

[![Laravel](https://img.shields.io/badge/Laravel-13.5-red.svg)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4-blue.svg)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-green.svg)](https://mysql.com/)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.4-cyan.svg)](https://tailwindcss.com/)
[![Railway](https://img.shields.io/badge/Railway-Deployed-purple.svg)](https://railway.app/)

**Application web de gestion d'un cabinet médical** développée avec Laravel 13, PHP 8.4, MySQL, Tailwind CSS et DomPDF.

🌐 **Lien de l'application déployée :** [https://medical-center-bahjawi.up.railway.app](https://medical-center-bahjawi.up.railway.app)

---

## 📸 Aperçu de l'application
 <div align="center">
  <img src="images/login.png" alt="Interface de connexion" width="800" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border: 1px solid #e2e8f0;"/>
  <br/>
  <em>Figure 1 : Interface de connexion utilisateur</em>
</div>
<div align="center">
  <img src="images/Dashboard principal.png" alt="Dashboard principal Bahjawa Medical Center" width="800" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border: 1px solid #e2e8f0;"/>
  <br/>
  <em>Figure 2 : Dashboard principal - Vue d'ensemble du cabinet</em>
</div>

<br/>

<div align="center">
  <img src="images/RDV.png" alt="Gestion des rendez-vous" width="800" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border: 1px solid #e2e8f0;"/>
  <br/>
  <em>Figure 3 : Interface de gestion des rendez-vous</em>
</div>
 

---

## ✨ Fonctionnalités

### 👥 Authentification multi-rôles
| Rôle | Accès |
|------|-------|
| 👑 Admin | Accès total à toutes les fonctionnalités |
| 👨‍⚕️ Médecin | Consultation des patients, prescriptions, gestion des disponibilités |
| 📋 Secrétaire | Gestion des rendez-vous, saisie des patients |
| 🧑 Patient | Prise de rendez-vous, historique, ordonnances |

### 🔧 Modules principaux

- ✅ **Gestion des utilisateurs** (CRUD complet)
- ✅ **Gestion des rendez-vous** avec statuts (en attente, confirmé, annulé)
- ✅ **Gestion des consultations médicales**
- ✅ **Génération de prescriptions/ordonnances en PDF** (DomPDF)
- ✅ **Gestion des disponibilités des médecins**
- ✅ **Notifications email** (Mailtrap en environnement local)
- ✅ **Dashboard avec statistiques** pour chaque rôle
- ✅ **Espace patient** avec historique et prise de rendez-vous
- ✅ **Export PDF** des ordonnances

---

## 🛠️ Stack technique

| Catégorie | Technologie |
|-----------|-------------|
| Backend | Laravel 13.5, PHP 8.4 |
| Base de données | MySQL 8.0 |
| Frontend | Tailwind CSS 3.4, Blade Templates |
| PDF Generation | barryvdh/laravel-dompdf |
| Email | Mailtrap (SMTP sandbox) |
| Déploiement | Railway (Docker) |
| Versioning | Git / GitHub |

---

## 📦 Installation locale

### Prérequis
- PHP 8.4+
- Composer
- MySQL 8.0+
- Node.js & NPM

### Étapes d'installation

```bash
# 1. Cloner le dépôt
git clone https://github.com/samidos03/medical-center-.git
cd medical-center-

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances frontend
npm install && npm run build

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer le fichier .env avec vos informations de base de données
# DB_DATABASE=medical_center
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Migrer et seed la base de données
php artisan migrate --seed

# 7. Lancer le serveur
php artisan serve
