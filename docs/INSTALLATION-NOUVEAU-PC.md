# 🖥️ Installation BiblioTech sur un Nouveau PC

Guide complet pour installer et démarrer l'application **BiblioTech Laravel** sur une nouvelle machine (Windows, macOS ou Linux).

---

## 📋 Table des Matières

1. [Prérequis Système](#-prérequis-système)
2. [Installation Windows](#-installation-windows)
3. [Installation Linux/Ubuntu](#-installation-linuxubuntu)
4. [Installation macOS](#-installation-macos)
5. [Récupération du Projet](#-récupération-du-projet)
6. [Installation Automatique](#-installation-automatique)
7. [Installation Manuelle](#-installation-manuelle)
8. [Vérification](#-vérification)
9. [Démarrage](#-démarrage)
10. [Dépannage](#-dépannage)

---

## 🎯 Prérequis Système

### **Logiciels Requis**

| Logiciel | Version Minimale | Utilisation |
|----------|------------------|-------------|
| **PHP** | 8.3+ | Framework Laravel |
| **Composer** | 2.x | Gestionnaire de dépendances PHP |
| **SQLite** | 3.x | Base de données (généralement inclus) |
| **Git** | 2.x | Récupération du code source |

### **Logiciels Optionnels**

| Logiciel | Utilité |
|----------|---------|
| **Node.js** 18+ | Compilation des assets frontend (optionnel) |
| **npm** 9+ | Gestionnaire de paquets JavaScript (avec Node.js) |

---

## 🪟 Installation Windows

### **Étape 1 : Installer PHP 8.3+**

**Option A : Installation Manuelle (Recommandée)**

1. **Télécharger PHP 8.3+** :
   - Rendez-vous sur https://windows.php.net/download/
   - Téléchargez **PHP 8.3.x Thread Safe (x64)**
   - Exemple : `php-8.3.11-Win32-vs16-x64.zip`

2. **Extraire PHP** :
   ```batch
   # Créer le dossier
   mkdir C:\PHP
   
   # Extraire le ZIP téléchargé dans C:\PHP
   # (Utiliser l'Explorateur Windows ou 7-Zip)
   ```

3. **Configurer PHP** :
   ```batch
   # Copier le fichier de configuration
   cd C:\PHP
   copy php.ini-development php.ini
   
   # Éditer php.ini et décommenter ces lignes (retirer le ; au début) :
   # extension=mbstring
   # extension=pdo_sqlite
   # extension=sqlite3
   # extension=openssl
   # extension=fileinfo
   ```

4. **Ajouter PHP au PATH** :
   - Ouvrir **Paramètres Windows** → **Système** → **Informations système** → **Paramètres système avancés**
   - Cliquer sur **Variables d'environnement**
   - Sous **Variables système**, sélectionner **Path** → **Modifier**
   - Cliquer sur **Nouveau** et ajouter : `C:\PHP`
   - Cliquer **OK** sur toutes les fenêtres

5. **Vérifier l'installation** :
   ```batch
   # Ouvrir un NOUVEAU terminal PowerShell ou CMD
   php -v
   # Devrait afficher : PHP 8.3.x ...
   ```

**Option B : Installation via Chocolatey**

```powershell
# Installer Chocolatey si nécessaire (PowerShell admin)
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))

# Installer PHP
choco install php --version=8.3.11 -y

# Vérifier
php -v
```

---

### **Étape 2 : Installer Composer**

1. **Télécharger Composer** :
   - https://getcomposer.org/Composer-Setup.exe

2. **Exécuter l'installateur** :
   - Double-cliquer sur `Composer-Setup.exe`
   - Suivre l'assistant (il détectera automatiquement PHP)
   - Laisser les options par défaut
   - Cliquer **Install**

3. **Vérifier l'installation** :
   ```batch
   # Ouvrir un NOUVEAU terminal
   composer --version
   # Devrait afficher : Composer version 2.x.x
   ```

---

### **Étape 3 : Installer Git**

1. **Télécharger Git** :
   - https://git-scm.com/download/win

2. **Installer Git** :
   - Exécuter l'installateur
   - Laisser les options par défaut
   - Cocher **Git Bash** et **Git from the command line**

3. **Vérifier** :
   ```batch
   git --version
   ```

---

## 🐧 Installation Linux/Ubuntu

### **Installation Complète (Ubuntu/Debian)**

```bash
# Mise à jour du système
sudo apt update && sudo apt upgrade -y

# Installer PHP 8.3 et extensions
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.3-cli php8.3-mbstring php8.3-xml php8.3-curl \
                    php8.3-sqlite3 php8.3-zip php8.3-bcmath php8.3-intl

# Vérifier PHP
php -v

# Installer Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Vérifier Composer
composer --version

# Installer Git
sudo apt install -y git

# Vérifier Git
git --version
```

---

## 🍎 Installation macOS

### **Installation via Homebrew**

```bash
# Installer Homebrew si nécessaire
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Installer PHP 8.3
brew install php@8.3
brew link php@8.3 --force

# Vérifier PHP
php -v

# Installer Composer
brew install composer

# Vérifier Composer
composer --version

# Installer Git (généralement préinstallé)
brew install git

# Vérifier Git
git --version
```

---

## 📦 Récupération du Projet

### **Cloner le Repository GitHub**

```bash
# Se placer dans le dossier de votre choix
cd C:\Users\VotreNom\Documents       # Windows
cd ~/Documents                        # Linux/macOS

# Cloner le projet
git clone https://github.com/ggaillard/bibliotech-laravel-SP.git

# Entrer dans le dossier
cd bibliotech-laravel-SP
```

---

## 🚀 Installation Automatique

### **Windows**

```batch
# Double-cliquer sur le fichier ou exécuter dans PowerShell/CMD
scripts\install.bat
```

Le script effectue automatiquement :
- ✅ Vérification de PHP et Composer
- ✅ Installation des dépendances Composer
- ✅ Copie et configuration du fichier `.env`
- ✅ Génération de la clé d'application Laravel
- ✅ Création de la base de données SQLite
- ✅ Exécution des migrations
- ✅ Insertion des données de test (seeders)
- ✅ Création du lien symbolique `storage`
- ✅ Nettoyage des caches

---

### **Linux/macOS**

```bash
# Rendre le script exécutable
chmod +x scripts/install.sh

# Exécuter le script
bash scripts/install.sh
```

Le script effectue les mêmes opérations que la version Windows.

---

## 🛠️ Installation Manuelle

Si vous préférez installer manuellement ou si les scripts échouent :

### **1. Installer les Dépendances PHP**

```bash
composer install --no-interaction --optimize-autoloader
```

### **2. Configurer l'Environnement**

```bash
# Copier le fichier d'exemple
cp .env.example .env       # Linux/macOS
copy .env.example .env     # Windows

# Générer la clé d'application
php artisan key:generate
```

### **3. Créer la Base de Données SQLite**

```bash
# Linux/macOS
touch database/database.sqlite

# Windows (PowerShell)
New-Item -ItemType File -Path database\database.sqlite

# Windows (CMD)
type nul > database\database.sqlite
```

### **4. Exécuter les Migrations**

```bash
php artisan migrate --force
```

### **5. Insérer les Données de Test**

```bash
php artisan db:seed --class=DatabaseSeeder --force
```

### **6. Créer le Lien Symbolique Storage**

```bash
php artisan storage:link
```

### **7. Nettoyer les Caches**

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## ✅ Vérification

### **Vérifier l'Installation**

```bash
# 1. Vérifier les versions
php -v
composer --version

# 2. Vérifier les migrations
php artisan migrate:status

# 3. Vérifier les données
php artisan tinker --execute="echo 'Livres: ' . \App\Models\Livre::count(); echo PHP_EOL . 'Catégories: ' . \App\Models\Categorie::count();"
# Devrait afficher : Livres: 6 et Catégories: 4

# 4. Lister les routes
php artisan route:list
```

### **Résultats Attendus**

| Vérification | Résultat Attendu |
|--------------|------------------|
| PHP version | 8.3.x ou supérieur |
| Composer version | 2.x.x ou supérieur |
| Migrations | Toutes "Ran" (exécutées) |
| Livres dans la BDD | 6 livres |
| Catégories dans la BDD | 4 catégories |
| Routes | Au moins 7 routes définies |

---

## 🌐 Démarrage

### **Méthode 1 : Script Automatique (Recommandé)**

**Windows :**
```batch
scripts\start.bat
```

**Linux/macOS :**
```bash
bash scripts/start.sh
```

### **Méthode 2 : Commande Manuelle**

```bash
php artisan serve --port=8000
```

### **Accès à l'Application**

Ouvrir un navigateur et accéder à :
```
http://localhost:8000
```

ou
```
http://127.0.0.1:8000
```

---

## 🎯 Pages Disponibles

| URL | Description |
|-----|-------------|
| `http://localhost:8000/` | Page d'accueil avec statistiques |
| `http://localhost:8000/livres` | Liste des 6 livres disponibles |
| `http://localhost:8000/livre/1` | Détail du livre #1 |
| `http://localhost:8000/recherche` | Formulaire de recherche |
| `http://localhost:8000/about` | À propos de BiblioTech |

---

## 🐛 Dépannage

### **Erreur : "PHP n'est pas reconnu"**

**Cause :** PHP n'est pas dans le PATH système.

**Solution Windows :**
```batch
# Vérifier où est installé PHP
where php

# Si rien n'apparaît, ajouter PHP au PATH (voir Étape 1)
```

**Solution Linux/macOS :**
```bash
# Vérifier PHP
which php

# Installer si manquant
sudo apt install php8.3-cli    # Ubuntu/Debian
brew install php@8.3            # macOS
```

---

### **Erreur : "Composer n'est pas reconnu"**

**Solution Windows :**
- Réinstaller Composer depuis https://getcomposer.org/Composer-Setup.exe
- Redémarrer le terminal

**Solution Linux/macOS :**
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

---

### **Erreur : "SQLSTATE[HY000]: no such table: livres"**

**Cause :** Les migrations n'ont pas été exécutées.

**Solution :**
```bash
php artisan migrate:fresh --seed
```

---

### **Erreur : "Class 'PDO' not found"**

**Cause :** Extension PHP SQLite non activée.

**Solution Windows :**
```batch
# Éditer C:\PHP\php.ini et décommenter :
extension=pdo_sqlite
extension=sqlite3

# Redémarrer le terminal
```

**Solution Linux :**
```bash
sudo apt install php8.3-sqlite3
```

---

### **Erreur : Port 8000 déjà utilisé**

**Solution :**
```bash
# Utiliser un autre port
php artisan serve --port=8080

# Accéder à : http://localhost:8080
```

---

### **Erreur : "Permission denied" (Linux/macOS)**

**Solution :**
```bash
# Donner les permissions nécessaires
chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

---

## 📚 Ressources Complémentaires

### **Documentation Projet**

- **[README Principal](../README.md)** - Vue d'ensemble du projet
- **[Guide Scripts](../scripts/README.md)** - Documentation des scripts
- **[Installation Codespace](INSTALLATION-CODESPACE.md)** - Installation GitHub Codespaces
- **[Installation Locale](INSTALLATION-LOCAL.md)** - Guide détaillé installation locale
- **[Séance 01](seance-01/00-README.md)** - Routes et MVC
- **[Séance 02](seance-02/00-README.md)** - Base de données et Eloquent
- **[Séance 03](seance-03/00-README.md)** - Contrôleurs et vues

### **Documentation Laravel**

- **[Laravel 12.x](https://laravel.com/docs/12.x)** - Documentation officielle
- **[Artisan CLI](https://laravel.com/docs/12.x/artisan)** - Commandes Artisan
- **[Eloquent ORM](https://laravel.com/docs/12.x/eloquent)** - Gestion base de données

---

## 🔄 Workflow Post-Installation

### **Développement Quotidien**

```bash
# 1. Démarrer le serveur
scripts\start.bat              # Windows
bash scripts/start.sh          # Linux/macOS

# 2. Accéder à l'application
# http://localhost:8000

# 3. Arrêter le serveur
# Ctrl+C dans le terminal
```

### **Après un `git pull`**

```bash
# Mettre à jour les dépendances et la base
composer install
php artisan migrate
php artisan db:seed
php artisan config:clear

# Redémarrer le serveur
php artisan serve
```

---

## ✅ Checklist Post-Installation

- [ ] PHP 8.3+ installé et dans le PATH
- [ ] Composer 2.x installé et fonctionnel
- [ ] Git installé (optionnel mais recommandé)
- [ ] Projet cloné depuis GitHub
- [ ] Script d'installation exécuté (ou installation manuelle complète)
- [ ] Fichier `.env` créé et configuré
- [ ] Base de données SQLite créée
- [ ] Migrations exécutées (8 migrations)
- [ ] Seeders exécutés (6 livres, 4 catégories)
- [ ] Serveur Laravel démarré
- [ ] Application accessible sur http://localhost:8000
- [ ] Page d'accueil affiche les statistiques
- [ ] Page `/livres` affiche 6 livres

---

**🎉 Félicitations ! BiblioTech est maintenant installé et prêt à l'emploi sur votre nouveau PC.**

**🆘 Besoin d'aide ?** Consultez la section [Dépannage](#-dépannage) ou ouvrez une issue sur GitHub.

**Dernière mise à jour :** 6 octobre 2025
