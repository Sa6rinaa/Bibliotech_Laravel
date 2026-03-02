# 📚 BiblioTech Laravel SP - Documentation des Fichiers Racine

> Guide complet des fichiers et répertoires à la racine du projet BiblioTech

---

## 🎯 Vue d'Ensemble

Ce document décrit **tous les fichiers importants à la racine** du projet BiblioTech Laravel SP et leur utilisation dans le workflow de développement BTS SIO SLAM.

---

## 📂 Structure et Description des Fichiers Racine

### **🔵 Fichiers de Configuration Essentiels**

#### **`.env` et `.env.example`**
**Description :** Fichiers de configuration environnement  
**Contenu :**
- URL de l'application (`APP_URL`)
- Clé de chiffrement (`APP_KEY`)
- Mode debug (`APP_DEBUG`)
- Configuration base de données (`DB_*`)
- Paramètres email et services externes

**Utilisation :**
- `.env.example` : Template de référence (livré avec le projet)
- `.env` : Configuration locale (créé automatiquement à l'installation, à ne **jamais** versionner)

**⚠️ Important :** Le fichier `.env` est ignoré par Git et contient des données sensibles. Chaque développeur en a une copie personnelle.

---

#### **`.env.testing`**
**Description :** Configuration pour les tests unitaires  
**Contenu :**
- `APP_ENV=testing`
- Base de données de test (SQLite en mémoire)
- Désactivation de cache et queue

**Utilisation :** Chargé automatiquement lors de `php artisan test`

---

### **🟢 Fichiers de Dépendances**

#### **`composer.json` et `composer.lock`**
**Description :** Gestion des dépendances PHP  
**Contenu :**
- `composer.json` : Liste des dépendances avec versions (flexibles)
- `composer.lock` : Versions exactes installées (à versionner absolument)

**Dépendances principales :**
```json
{
  "laravel/framework": "^12.0",
  "php": "^8.3",
  "spatie/laravel-permission": "^6.0",
  "laravel/sanctum": "^4.0"
}
```

**Utilisation :**
```bash
# Installer/mettre à jour les dépendances
composer install          # Installation avec versions de composer.lock
composer update          # Mise à jour avec nouvelles versions compatibles
composer require xxx     # Ajouter une nouvelle dépendance
```

---

### **🟡 Fichiers de Démarrage et Installation**

#### **`scripts/install.bat` (Windows)**
**Description :** Script d'installation automatique pour Windows  
**Rôle :**
1. Vérifie PHP et Composer
2. Installe les dépendances Composer
3. Copie `.env.example` → `.env`
4. Génère la clé d'application
5. Crée la base SQLite
6. Exécute les migrations
7. Lance les seeders (données de test)
8. Configure les permissions

**Utilisation :**
```batch
# Double-cliquer sur le fichier
scripts\install.bat

# Ou en terminal PowerShell
.\scripts\install.bat
```

---

#### **`scripts/install.sh` (Linux/macOS)**
**Description :** Équivalent du script d'installation pour Linux/macOS  
**Identique au `.bat` mais avec syntaxe Bash**

**Utilisation :**
```bash
chmod +x scripts/install.sh
bash scripts/install.sh
```

---

#### **`scripts/start.bat` et `scripts/start.sh`**
**Description :** Scripts de démarrage quotidien du serveur  
**Rôle :**
1. Vérifie l'état du projet
2. Lance le serveur Laravel sur le port 8000
3. Affiche l'URL d'accès
4. Monitore les erreurs

**Utilisation :**
```bash
# Windows
scripts\start.bat

# Linux/macOS
bash scripts/start.sh
```

**Résultat :** Application accessible sur `http://localhost:8000`

---

#### **`scripts/start-simple.bat` et `scripts/start-simple.sh`**
**Description :** Démarrage rapide pour développeurs expérimentés  
**Différence :** Pas de vérifications préalables, direct au serveur

**Utilisation :**
```bash
scripts\start-simple.bat    # Windows
bash scripts/start-simple.sh # Linux
```

---

#### **`scripts/diagnostic.bat` et `scripts/diagnostic.sh`**
**Description :** Outil de diagnostic pour résoudre les problèmes  
**Fonctionnalités :**
- Vérifie la version de PHP
- Vérifie les extensions PHP requises
- Teste la base de données
- Affiche les permissions des dossiers
- Propose des solutions aux problèmes détectés

**Utilisation :**
```bash
scripts\diagnostic.bat      # Windows
bash scripts/diagnostic.sh  # Linux
```

---

### **🔴 Fichiers de Contrôle de Version**

#### **`.gitignore`**
**Description :** Fichiers et dossiers ignorés par Git  
**Contenu typique :**
```
# Environnement
.env
.env.*.php

# Dépendances
/vendor
/node_modules

# Caches et logs
/storage
/bootstrap/cache
.DS_Store
Thumbs.db
```

**⚠️ Important :** Certains fichiers sensibles (`.env`, `/vendor`) ne doivent JAMAIS être versionés.

---

#### **`.gitattributes`**
**Description :** Configuration de Git pour normaliser les fins de ligne  
**Contenu :**
```
* text=auto
*.php text eol=lf
*.md text eol=lf
```

**Rôle :** Évite les problèmes de fin de ligne entre Windows (CRLF) et Linux (LF)

---

### **🟣 Fichiers de Configuration Docker**

#### **`docker-compose.yml`**
**Description :** Configuration des conteneurs Docker pour développement  
**Services configurés :**
- **php** : Container PHP 8.3 avec extensions Laravel
- **nginx** : Serveur web Nginx (port 80)
- **sqlite** : Base de données SQLite
- **mailhog** : Service de test email (port 1025)

**Utilisation :**
```bash
docker-compose up -d        # Démarrer les conteneurs
docker-compose down         # Arrêter les conteneurs
docker-compose logs -f      # Voir les logs en temps réel
```

**À noter :** Dans ce projet, Docker est optionnel. Vous pouvez développer sans si vous avez PHP et Composer locaux.

---

#### **`.devcontainer/devcontainer.json`**
**Description :** Configuration pour GitHub Codespaces  
**Rôle :**
1. Configure l'environnement Codespaces
2. Installe PHP 8.3, Composer, Git
3. Lance automatiquement l'installation (`onCreateCommand`)
4. Crée les extensions VS Code utiles

**Utilisé uniquement :** Lors du démarrage d'un Codespace GitHub

---

### **⚫ Fichiers CI/CD**

#### **`.github/workflows/laravel-ci.yml`**
**Description :** Pipeline d'intégration continue GitHub Actions  
**Processus automatisé :**
1. **À chaque push** : Tests automatiques
2. **Tests unitaires** : PHPUnit sur les tests
3. **Analyse de code** : PHPStan pour vérifier la qualité
4. **Vérification style** : Laravel Pint pour la cohérence
5. **Audit sécurité** : Composer audit pour les vulnérabilités

**Utilisation :** Automatique à chaque commit sur `main` ou `seance-*`

---

### **🔵 Fichiers de Configuration Laravel**

#### **`config/app.php`**
**Description :** Configuration générale de l'application  
**Paramètres clés :**
- Nom de l'app (`APP_NAME`)
- Locale (fr_FR)
- Fuseau horaire (Europe/Paris)
- Classe de provider racine

**Modification :** Rarement nécessaire. Utiliser `.env` en priorité.

---

#### **`config/database.php`**
**Description :** Configuration des bases de données  
**Pour ce projet :**
```php
'default' => 'sqlite',
'connections' => [
    'sqlite' => [
        'driver' => 'sqlite',
        'url' => env('DATABASE_URL'),
        'database' => env('DB_DATABASE', database_path('database.sqlite')),
    ],
],
```

**Modification :** Très rarement. Laisser la config SQLite par défaut.

---

#### **`config/filesystems.php`**
**Description :** Configuration du stockage de fichiers  
**Disques disponibles :**
- `local` : Dossier `/storage/app` (uploads d'utilisateurs)
- `public` : Dossier `/public/storage` (fichiers accessibles publiquement)
- `s3` : Amazon S3 (production)

**Utilisation :**
```php
// Stocker un fichier
Storage::disk('public')->put('livres/couverture.jpg', $file);

// Récupérer une URL
$url = Storage::disk('public')->url('livres/couverture.jpg');
```

---

#### **`config/mail.php`**
**Description :** Configuration de l'envoi d'emails  
**Pour développement :**
```php
'mailer' => 'log',  // Les emails s'écrivent dans les logs
```

**Pour tests :**
```php
'mailer' => 'mailhog',  // Utilise le container MailHog
```

---

### **🟠 Fichiers de Routes**

#### **`routes/web.php`**
**Description :** Définition des routes HTTP accessibles publiquement  
**Contenu :**
- Routes de pages (`/`, `/about`)
- Routes pour les livres (`/livres`, `/livre/{id}`)
- Routes d'authentification (futures)

**Exemple :**
```php
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');
Route::get('/livre/{id}', [LivreController::class, 'show'])->name('livres.show');
```

**Modification :** À chaque ajout de nouvelle page/fonctionnalité.

---

#### **`routes/api.php`**
**Description :** Définition des routes API (endpoints JSON)  
**Actuellement :** Vide (sera utilisé pour les API futures)

**Exemple futur :**
```php
Route::get('/api/livres', [LivreApiController::class, 'index']);
```

---

### **🟢 Fichiers d'Application**

#### **`artisan`**
**Description :** Script CLI pour exécuter les commandes Laravel  
**Usage :** À ne **jamais** modifier  
**Utilisation :**
```bash
php artisan serve                 # Lancer le serveur
php artisan migrate              # Exécuter les migrations
php artisan test                 # Lancer les tests
php artisan tinker               # Shell interactif PHP
php artisan make:controller Nom  # Créer un contrôleur
```

---

#### **`package.json` et `package-lock.json`**
**Description :** Gestion des dépendances JavaScript/Node.js  
**Contenu :**
- Build tools (Vite, Laravel Mix)
- Dépendances CSS (Bootstrap)
- Dépendances JS (AlpineJS, etc.)

**Utilisation :**
```bash
npm install          # Installer les dépendances
npm run dev          # Build en développement avec Vite
npm run build        # Build pour production
```

---

### **🔴 Fichiers de Documentation**

#### **`README.md`**
**Description :** Documentation principale du projet  
**Contenu :**
- Présentation du projet BiblioTech
- Instructions d'installation (rapide et détaillée)
- Documentation par séance
- Troubleshooting
- Stack technologique

**Utilisation :** Point d'entrée pour tout nouveau développeur/apprenant

---

#### **`CHANGELOG.md`**
**Description :** Historique des modifications par version  
**Format :** Keepachangelog (standard du secteur)
**Contenu :**
- Version
- Date
- Changements (Added, Changed, Fixed, Removed)

**Utilisation :** Voir ce qui a changé entre deux versions

---

### **🟡 Fichiers de Configuration Git et GitHub**

#### **`CONTRIBUTING.md`**
**Description :** Guide pour contribuer au projet  
**Contenu :**
- Comment configurer l'environnement
- Convention de nommage des branches
- Processus de pull request
- Standards de code

**Utilisation :** Pour les étudiants collaborant au projet

---

#### **`LICENSE`**
**Description :** Licence du projet (MIT)  
**Signification :** Le code peut être utilisé librement, y compris commercialement  
**À conserver :** Obligatoire légalement

---

---

## 🗂️ Organisation Recommandée des Répertoires

### **Répertoires Principaux**

```
bibliotech-laravel-SP/
├── 📁 app/                  # Code application (contrôleurs, modèles)
├── 📁 bootstrap/            # Fichiers de démarrage Laravel (ne pas modifier)
├── 📁 config/               # Fichiers de configuration
├── 📁 database/             # Migrations, seeders, base SQLite
├── 📁 resources/            # Vues Blade, CSS, JavaScript
├── 📁 routes/               # Définition des routes
├── 📁 storage/              # Fichiers uploadés, logs, cache
├── 📁 tests/                # Tests unitaires et fonctionnels
├── 📁 scripts/              # Scripts d'installation et démarrage
├── 📁 docs/                 # Documentation pédagogique
├── 📁 public/               # Fichiers accessibles publiquement
├── 📁 .github/              # Configuration GitHub (CI/CD)
└── 📁 vendor/               # Dépendances PHP (ne pas modifier)
```

---

## 🎯 Flux de Développement Type

### **1️⃣ Installation Initiale**

```bash
# Cloner le projet
git clone https://github.com/ggaillard/bibliotech-laravel-SP.git
cd bibliotech-laravel-SP

# Installation automatique
scripts\install.bat          # Windows
bash scripts/install.sh      # Linux/macOS
```

**Fichiers créés :** `.env`, `vendor/`, `database/database.sqlite`

---

### **2️⃣ Développement Quotidien**

```bash
# Démarrer le serveur
scripts\start.bat            # Windows
bash scripts/start.sh        # Linux/macOS

# Modifier le code dans app/, resources/, routes/

# Ajouter une dépendance si besoin
composer require nouvelledependance

# Lancer les tests
php artisan test
```

---

### **3️⃣ Versionner le Travail**

```bash
# Voir les changements
git status

# Ajouter les fichiers modifiés
git add app/ resources/ routes/ database/migrations/

# Commit avec message explicite
git commit -m "Feat: ajouter la gestion des emprunts"

# Envoyer vers GitHub
git push origin nombranche
```

**À NE PAS versionner :** `.env`, `/vendor`, `/node_modules`, `/storage`, `/bootstrap/cache`

---

### **4️⃣ Avant de Soumettre**

```bash
# Vérifier que tout compile
php artisan tinker --execute="echo 'OK';"

# Lancer les tests
php artisan test

# Vérifier les erreurs PHP
vendor/bin/phpstan analyse app

# Vérifier le style de code
vendor/bin/pint
```

---

## 🛠️ Commandes Essentielles

| Commande | Fonction | Quand l'utiliser |
|----------|----------|------------------|
| `php artisan serve` | Démarrer le serveur | Développement local |
| `php artisan migrate` | Exécuter les migrations | Créer/modifier la structure BD |
| `php artisan make:model Nom` | Créer un modèle | Nouvelle entité |
| `php artisan make:controller NomController` | Créer un contrôleur | Nouvelle fonctionnalité |
| `php artisan test` | Lancer les tests | Avant chaque commit |
| `php artisan tinker` | Shell PHP interactif | Tester du code rapidement |
| `composer install` | Installer les dépendances | Après clonage du projet |
| `npm install && npm run dev` | Compiler les assets | Modification de CSS/JS |

---

## ⚠️ Fichiers à NE PAS Modifier

| Fichier | Raison |
|---------|--------|
| `.gitignore` | Configuration importante de Git |
| `artisan` | Script système Laravel |
| `/vendor` | Dépendances PHP (auto-généré) |
| `/bootstrap/cache` | Cache auto-généré |
| `composer.lock` | À versionner, pas à modifier manuellement |
| `/public/index.php` | Point d'entrée système |
| `/bootstrap/app.php` | Configuration système |

---

## ✅ Résumé des Fichiers Essentiels

### **À Connaître**

| Fichier | Rôle | Priorité |
|---------|------|----------|
| `.env` | Configuration locale | 🔴 CRITIQUE |
| `composer.json` | Dépendances PHP | 🔴 CRITIQUE |
| `routes/web.php` | Définition des routes | 🟡 IMPORTANTE |
| `database/` | Migrations et données | 🟡 IMPORTANTE |
| `app/Http/Controllers/` | Logique métier | 🟡 IMPORTANTE |
| `resources/views/` | Templates HTML | 🟡 IMPORTANTE |
| `scripts/install.bat` | Installation | 🟢 UTILE |
| `scripts/start.bat` | Démarrage | 🟢 UTILE |
| `README.md` | Documentation | 🟢 UTILE |

---

## 🔗 Liens Utiles

- **Documentation Laravel** : https://laravel.com/docs
- **Documentation PHP** : https://www.php.net/docs.php
- **Référence Composer** : https://getcomposer.org/doc/
- **Forum Laravel** : https://laracasts.com

---

## 📞 Support et Aide

**Problèmes d'installation ?**
```bash
bash scripts/diagnostic.sh    # Lancer le diagnostic
```

**Besoin d'aide sur une commande ?**
```bash
php artisan help nomcommande
```

**Consulter la documentation locale :**
```
docs/INSTALLATION-LOCAL.md
docs/QUICK-START.md
docs/TROUBLESHOOTING.md
```

---

**Document généré pour la formation BTS SIO SLAM**  
*Dernière mise à jour : février 2026*
