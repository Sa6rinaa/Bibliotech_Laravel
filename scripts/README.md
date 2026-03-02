# 📜 Scripts BiblioTech - Guide d'Utilisation

Ce dossier contient les scripts d'installation et de démarrage de l'application **BiblioTech Laravel**.

---

## 🚀 Scripts Principaux

### **Windows (Batch)**

#### **`start.bat`** - Démarrage Complet avec Vérifications
Script principal pour démarrer l'application sur Windows avec toutes les vérifications :
- ✅ Vérifie la présence de PHP et Composer
- ✅ Copie `.env` depuis `.env.example` si nécessaire
- ✅ Génère la clé d'application (`APP_KEY`)
- ✅ Installe les dépendances Composer
- ✅ Efface les caches Laravel
- ✅ Vérifie les migrations de base de données
- ✅ Crée le lien symbolique `storage`
- ✅ Démarre le serveur Laravel sur le port 8000 (ou automatique si occupé)

**Usage :**
```batch
scripts\start.bat
```

**Caractéristiques :**
- ✅ Compatible avec tous les terminaux Windows (CMD, PowerShell, Windows Terminal)
- ✅ Version ASCII uniquement (pas d'emoji/Unicode) pour éviter les problèmes d'encodage
- ✅ Sortie claire et lisible dans tous les environnements

---

#### **`install.bat`** - Installation Complète Automatique
Script d'installation initiale de l'application (première fois uniquement) :
- ✅ Installe les dépendances Composer
- ✅ Configure l'environnement (`.env`)
- ✅ Génère la clé d'application
- ✅ Crée la base de données SQLite
- ✅ Exécute les migrations et seeders

**Usage :**
```batch
scripts\install.bat
```

---

### **Linux/macOS/WSL (Bash)**

#### **`start.sh`** - Démarrage Complet Linux/macOS
Script principal pour démarrer l'application sur Linux, macOS ou WSL :
- ✅ Toutes les vérifications du script Windows
- ✅ Compatible avec les environnements Bash
- ✅ Support Docker et environnements natifs

**Usage :**
```bash
bash scripts/start.sh
```

**Prérequis :**
- PHP 8.3+ installé et dans le PATH
- Composer installé
- SQLite installé (généralement inclus par défaut)

---

#### **`install.sh`** - Installation Complète Linux/macOS
Script d'installation initiale pour environnements Unix :
- ✅ Installation automatique des dépendances
- ✅ Configuration de l'environnement
- ✅ Création et migration de la base SQLite

**Usage :**
```bash
bash scripts/install.sh
```

---

## 🛠️ Scripts Auxiliaires

### **`diagnostic.bat`** / **`diagnostic.sh`**
Scripts de diagnostic pour identifier et résoudre les erreurs courantes :
- Vérification de l'environnement PHP/Composer
- Test de connexion à la base de données
- Vérification des permissions
- Analyse des logs Laravel

**Usage :**
```batch
scripts\diagnostic.bat          # Windows
bash scripts/diagnostic.sh      # Linux/macOS
```

---

### **`start-simple.bat`** / **`start-simple.sh`**
Démarrage rapide sans vérifications avancées (pour développement uniquement).

**Usage :**
```batch
scripts\start-simple.bat        # Windows
bash scripts/start-simple.sh    # Linux/macOS
```

---

## 📋 Quel Script Utiliser ?

### **Première Installation**
```batch
# Windows
scripts\install.bat

# Linux/macOS/WSL
bash scripts/install.sh
```

### **Démarrage Quotidien (Recommandé)**
```batch
# Windows
scripts\start.bat

# Linux/macOS/WSL
bash scripts/start.sh
```

### **Démarrage Rapide (Développeurs Expérimentés)**
```batch
# Windows
scripts\start-simple.bat

# Linux/macOS
bash scripts/start-simple.sh
```

### **Diagnostic et Dépannage**
```batch
# Windows
scripts\diagnostic.bat

# Linux/macOS
bash scripts/diagnostic.sh
```

---

## ⚙️ Configuration Requise

### **Windows**
- **PHP** 8.3+ dans le PATH (ex: `C:\PHP`)
- **Composer** dans le PATH (ex: `C:\composer`)
- **Terminal** : CMD, PowerShell, ou Windows Terminal

### **Linux/macOS/WSL**
- **PHP** 8.3+ (`php -v` pour vérifier)
- **Composer** 2.x (`composer --version`)
- **SQLite** (généralement préinstallé)
- **Bash** shell

---

## 🐛 Résolution de Problèmes

### **Erreur : "PHP n'est pas installé ou pas dans le PATH"**
**Windows :**
```batch
# Vérifier l'installation PHP
where php

# Ajouter PHP au PATH si nécessaire
setx PATH "%PATH%;C:\PHP"
```

**Linux/macOS :**
```bash
# Vérifier PHP
which php

# Installer PHP si manquant (Ubuntu/Debian)
sudo apt install php8.3-cli php8.3-sqlite3 php8.3-mbstring
```

---

### **Erreur : "Composer n'est pas trouvé"**
**Windows :**
- Télécharger : https://getcomposer.org/Composer-Setup.exe
- Installer et redémarrer le terminal

**Linux/macOS :**
```bash
# Installer Composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
```

---

### **Erreur : Caractères illisibles dans start.bat**
**Solution :** Le script `start.bat` a été mis à jour pour utiliser uniquement des caractères ASCII.
Si vous rencontrez toujours des problèmes, vérifiez l'encodage de votre terminal :
```batch
chcp 65001
scripts\start.bat
```

---

### **Erreur : "artisan not found"**
**Cause :** Vous n'êtes pas dans le répertoire racine du projet.

**Solution :**
```batch
# Naviguer vers le dossier du projet
cd C:\Users\gaill\Documents\Laravel\bibliotech-laravel-SP

# Puis lancer le script
scripts\start.bat
```

---

## 📚 Documentation Complémentaire

- **[Installation Codespace](../docs/INSTALLATION-CODESPACE.md)** - Installation GitHub Codespaces (recommandé débutants)
- **[Installation Locale](../docs/INSTALLATION-LOCAL.md)** - Guide complet installation locale (Windows/macOS/Linux)
- **[Démarrage Rapide](../docs/QUICK-START.md)** - Guide de démarrage rapide (2 minutes)
- **[Troubleshooting](../docs/TROUBLESHOOTING.md)** - Guide de résolution de problèmes

---

## 🔄 Workflow Recommandé

### **Développement Quotidien**
```batch
# 1. Démarrer le serveur
scripts\start.bat                    # Windows
bash scripts/start.sh                # Linux/macOS

# 2. Accéder à l'application
# Navigateur : http://localhost:8000

# 3. Arrêter le serveur
# Ctrl+C dans le terminal
```

### **Après un `git pull`**
```batch
# Mettre à jour les dépendances et la base
composer install
php artisan migrate
php artisan db:seed

# Puis démarrer
scripts\start.bat
```

---

## ✅ Vérification Post-Installation

Après l'exécution du script d'installation, vérifiez :

```batch
# 1. Vérifier PHP et Composer
php -v
composer --version

# 2. Vérifier la base de données
php artisan migrate:status

# 3. Vérifier les données de test
php artisan tinker
>>> App\Models\Livre::count()
>>> exit

# 4. Démarrer le serveur
scripts\start.bat                    # Windows
bash scripts/start.sh                # Linux/macOS

# 5. Accéder à : http://localhost:8000
```

---

## 📝 Maintenance des Scripts

### **Scripts Conservés (Essentiels)**
- ✅ `start.bat` - Démarrage Windows (version ASCII, compatible tous terminaux)
- ✅ `start.sh` - Démarrage Linux/macOS
- ✅ `install.bat` - Installation Windows
- ✅ `install.sh` - Installation Linux/macOS

### **Scripts Optionnels**
- `diagnostic.bat` / `diagnostic.sh` - Diagnostic système
- `start-simple.bat` / `start-simple.sh` - Démarrage rapide développeurs
- `protect-branches.ps1` - Protection branches Git (PowerShell)

---

**🎯 Besoin d'aide ?** Consultez la [documentation principale](../README.md) ou ouvrez une issue sur GitHub.

**Dernière mise à jour :** 6 octobre 2025
