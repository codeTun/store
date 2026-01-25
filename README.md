# StockMaster - Système de Gestion d'Inventaire

Un système de gestion d'inventaire simple et moderne développé avec Laravel et TailwindCSS.

---

## Aperçu

StockMaster permet de gérer facilement :
- Les **produits** (création, modification, suppression)
- Les **catégories** pour organiser les produits
- Les **fournisseurs** avec leurs coordonnées
- Les **mouvements de stock** (entrées et sorties)
- Un **dashboard** avec statistiques et alertes

---

## Prérequis

Avant de commencer, assurez-vous d'avoir installé :

| Outil | Version minimum |
|-------|-----------------|
| PHP | 8.1 ou plus |
| Composer | 2.0 ou plus |
| MySQL | 5.7 ou plus |
| Node.js | 18 ou plus (optionnel) |

---

## Installation

### 1. Cloner le projet

```bash
git clone <url-du-projet>
cd mini-projet
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Configurer l'environnement

Copier le fichier d'exemple et le modifier :

```bash
cp .env.example .env
```

Ouvrir `.env` et configurer la base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini-projet
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Créer la base de données

Dans MySQL, créer la base de données :

```sql
CREATE DATABASE `mini-projet` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Générer la clé d'application

```bash
php artisan key:generate
```

### 6. Exécuter les migrations et les données de test

```bash
php artisan migrate --seed
```

### 7. Lancer le serveur

```bash
php artisan serve
```

L'application est accessible sur : **http://127.0.0.1:8000**

---

## Connexion

Un compte administrateur est créé automatiquement :

| Champ | Valeur |
|-------|--------|
| Email | `admin@admin.com` |
| Mot de passe | `password` |

---

## Structure du Projet

```
mini-projet/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── AuthenticatedSessionController.php  # Login/Logout
│   │   │   ├── CategoryController.php     # Gestion des catégories
│   │   │   ├── Controller.php             # Controller de base
│   │   │   ├── DashboardController.php    # Page d'accueil
│   │   │   ├── ProductController.php      # Gestion des produits
│   │   │   ├── StockController.php        # Mouvements de stock
│   │   │   └── SupplierController.php     # Gestion des fournisseurs
│   │   └── Requests/Auth/
│   │       └── LoginRequest.php           # Validation login
│   └── Models/
│       ├── Category.php                   # Modèle catégorie
│       ├── Product.php                    # Modèle produit
│       ├── StockMovement.php              # Modèle mouvement
│       ├── Supplier.php                   # Modèle fournisseur
│       └── User.php                       # Modèle utilisateur
├── database/
│   ├── migrations/                        # Structure des tables
│   └── seeders/
│       └── DatabaseSeeder.php             # Données de test
├── resources/views/
│   ├── auth/
│   │   └── login.blade.php                # Page de connexion
│   ├── categories/                        # Vues catégories (CRUD)
│   ├── layouts/
│   │   └── app.blade.php                  # Template principal
│   ├── products/                          # Vues produits (CRUD)
│   ├── stock/                             # Vues mouvements
│   ├── suppliers/                         # Vues fournisseurs (CRUD)
│   ├── dashboard.blade.php                # Tableau de bord
│   └── welcome.blade.php                  # Page d'accueil (redirect)
└── routes/
    ├── auth.php                           # Routes login/logout
    └── web.php                            # Routes principales
```

---

## Fonctionnalités

### Dashboard
- Nombre total de produits, catégories, fournisseurs
- Valeur totale du stock
- Calcul du gain potentiel (prix vente - prix achat)
- Alertes pour les produits en stock faible
- Historique des derniers mouvements

### Produits
- Liste avec recherche en temps réel
- Création avec : nom, SKU, catégorie, fournisseur, prix, quantité
- Modification des informations
- Suppression
- Détail avec historique des mouvements

### Catégories
- Liste avec nombre de produits par catégorie
- Création / Modification / Suppression
- Protection contre la suppression si produits associés

### Fournisseurs
- Liste avec coordonnées
- Création / Modification / Suppression
- Visualisation des produits par fournisseur

### Mouvements de Stock
- Enregistrement des entrées (réception marchandise)
- Enregistrement des sorties (ventes, pertes)
- Historique complet avec date, produit, quantité, raison
- Mise à jour automatique du stock produit

---

## Base de Données

### Tables principales

**products** - Les produits
| Colonne | Type | Description |
|---------|------|-------------|
| id | int | Identifiant unique |
| name | string | Nom du produit |
| sku | string | Référence unique |
| category_id | int | Catégorie |
| supplier_id | int | Fournisseur (optionnel) |
| purchase_price | decimal | Prix d'achat |
| selling_price | decimal | Prix de vente |
| quantity | int | Quantité en stock |
| min_quantity | int | Seuil d'alerte |
| description | text | Description |

**categories** - Les catégories
| Colonne | Type | Description |
|---------|------|-------------|
| id | int | Identifiant unique |
| name | string | Nom de la catégorie |
| description | text | Description |

**suppliers** - Les fournisseurs
| Colonne | Type | Description |
|---------|------|-------------|
| id | int | Identifiant unique |
| name | string | Nom du fournisseur |
| email | string | Email |
| phone | string | Téléphone |
| address | text | Adresse |

**stock_movements** - Les mouvements
| Colonne | Type | Description |
|---------|------|-------------|
| id | int | Identifiant unique |
| product_id | int | Produit concerné |
| user_id | int | Utilisateur |
| type | enum | 'entry' ou 'exit' |
| quantity | int | Quantité (+/-) |
| reason | string | Raison du mouvement |

---

## Routes de l'Application

| Méthode | URL | Action |
|---------|-----|--------|
| GET | `/` | Redirection vers login |
| GET | `/login` | Page de connexion |
| POST | `/login` | Authentification |
| POST | `/logout` | Déconnexion |
| GET | `/dashboard` | Tableau de bord |
| GET | `/products` | Liste des produits |
| GET | `/products/create` | Formulaire création |
| POST | `/products` | Créer un produit |
| GET | `/products/{id}` | Détail d'un produit |
| GET | `/products/{id}/edit` | Formulaire modification |
| PUT | `/products/{id}` | Modifier un produit |
| DELETE | `/products/{id}` | Supprimer un produit |
| GET | `/categories` | Liste des catégories |
| GET | `/suppliers` | Liste des fournisseurs |
| GET | `/stock` | Liste des mouvements |
| GET | `/stock/create` | Formulaire mouvement |
| POST | `/stock` | Enregistrer mouvement |

---

## Technologies Utilisées

| Technologie | Utilisation |
|-------------|-------------|
| **Laravel 11** | Framework PHP backend |
| **TailwindCSS** | Framework CSS (via CDN) |
| **MySQL** | Base de données |
| **Blade** | Moteur de templates |
| **Laravel Breeze** | Authentification |

---

## Personnalisation

### Changer la devise

Dans les fichiers `resources/views/`, remplacer `DT` par votre devise :
- `dashboard.blade.php`
- `products/index.blade.php`
- `products/show.blade.php`
- `products/create.blade.php`
- `products/edit.blade.php`

### Ajouter des données de test

Modifier `database/seeders/DatabaseSeeder.php` pour ajouter vos propres données.

---

## Commandes Utiles

```bash
# Vider le cache
php artisan cache:clear
php artisan config:clear

# Recréer la base de données
php artisan migrate:fresh --seed

# Voir les routes
php artisan route:list
```

---

## Résolution de Problèmes

### "Database does not exist"
Vérifier que la base de données est créée et que `.env` est bien configuré.

### "Class not found"
Exécuter : `composer dump-autoload`

### Les styles ne s'affichent pas
Vérifier la connexion internet (TailwindCSS est chargé via CDN).

---

## Auteur

Projet développé dans le cadre du cours **Framework WEB (Symfony/Laravel)** - ING2.

---

## Licence

Ce projet est à usage éducatif.
