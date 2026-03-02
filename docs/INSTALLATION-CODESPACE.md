# ☁️ Installation GitHub Codespace - BiblioTech Laravel

> **Guide complet pour utiliser BiblioTech dans GitHub Codespaces**

---

## 🚀 **Qu'est-ce que GitHub Codespace ?**

GitHub Codespace est un environnement de développement intégré (IDE) dans le cloud qui permet d'exécuter VS Code directement dans votre navigateur avec un environnement Linux préconfiguré.

### **✅ Avantages pour BiblioTech**
- **Installation zéro** : Pas besoin d'installer PHP, Composer ou Laravel localement
- **Environnement uniforme** : Tous les étudiants ont la même configuration
- **Accès partout** : Depuis n'importe quel ordinateur avec internet
- **Performance** : Serveurs GitHub puissants
- **Collaboration** : Partage facile avec formateurs et collègues

---

## 🎯 **Démarrage Rapide (30 secondes)**

### **Étape 1 : Créer le Codespace**
1. Rendez-vous sur le repository GitHub du projet BiblioTech
2. Cliquez sur le bouton vert **"< > Code"**
3. Sélectionnez l'onglet **"Codespaces"**
4. Cliquez sur **"Create codespace on main"**

### **Étape 2 : Attendre l'initialisation**
Le Codespace va automatiquement :
- ✅ Créer l'environnement Linux
- ✅ Installer PHP 8.3 et Composer
- ✅ Installer les dépendances Laravel
- ✅ Configurer la base de données SQLite
- ✅ Démarrer l'application

### **Étape 3 : Accéder à l'application**
1. Une fois l'initialisation terminée, cherchez l'onglet **"PORTS"** en bas
2. Cliquez sur l'icône **🌐** à côté du port **8000**
3. L'application BiblioTech s'ouvre dans un nouvel onglet !

**🎉 C'est terminé ! Vous avez BiblioTech fonctionnel en moins d'une minute !**

---

## 🔧 **Configuration Automatique**

Le projet BiblioTech inclut une configuration Codespace dans `.devcontainer/devcontainer.json` qui :

### **🐳 Image de Base**
```json
{
  "image": "mcr.microsoft.com/devcontainers/php:1-8.3-bullseye",
  "features": {
    "ghcr.io/devcontainers/features/node:1": {
      "version": "lts"
    }
  }
}
```

### **🔧 Scripts de Post-Création**
```json
{
  "postCreateCommand": "bash .devcontainer/setup.sh"
}
```

Le script `setup.sh` exécute automatiquement :
```bash
#!/bin/bash
echo "🚀 Configuration automatique de BiblioTech..."

# Installation des dépendances
composer install

# Configuration de l'environnement
cp .env.example .env
php artisan key:generate

# Création de la base SQLite
touch database/database.sqlite

# Migration de la base de données
php artisan migrate --seed

# Démarrage du serveur
php artisan serve --host=0.0.0.0 --port=8000
```

### **🌐 Ports Exposés**
- **8000** : Application Laravel (auto-forward)
- **8025** : MailHog (optionnel, pour les emails de dev)
- **5432** : PostgreSQL (séances avancées)

---

## 💡 **Utilisation Optimale du Codespace**

### **🎯 Interface VS Code**
Le Codespace vous donne accès à VS Code complet avec :
- **Explorateur de fichiers** : Navigation dans le projet
- **Terminal intégré** : Commandes Laravel et git
- **Extensions recommandées** : PHP, Laravel, Blade automatiquement installées
- **IntelliSense** : Auto-complétion complète pour PHP et Laravel

### **⚡ Commandes Utiles dans le Terminal**
```bash
# Démarrer le serveur (si pas déjà fait)
php artisan serve --host=0.0.0.0 --port=8000

# Voir les routes disponibles
php artisan route:list

# Console interactive Laravel
php artisan tinker

# Nettoyage du cache
php artisan optimize:clear

# Voir les logs en temps réel
tail -f storage/logs/laravel.log
```

### **🔄 Redémarrage du Serveur**
Si le serveur s'arrête :
```bash
# Ctrl+C pour arrêter si nécessaire
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 📁 **Gestion des Fichiers**

### **💾 Sauvegarde Automatique**
- Les modifications sont **automatiquement sauvées** dans GitHub
- Pas besoin de commit manuel pour les tests
- Le Codespace persiste entre les sessions

### **📤 Partage et Collaboration**
```bash
# Créer une branche pour vos modifications
git checkout -b ma-fonctionnalite

# Sauvegarder vos changements
git add .
git commit -m "Ajout de ma fonctionnalité"
git push origin ma-fonctionnalite
```

### **🔽 Télécharger des Fichiers**
- **Clic droit** sur un fichier dans l'explorateur → **Download**
- Utile pour récupérer la base SQLite ou des logs

---

## 🛠️ **Personnalisation de l'Environnement**

### **🎨 Extensions Recommandées**
Les extensions suivantes sont automatiquement installées :
- **PHP Intelephense** : Auto-complétion PHP avancée
- **Laravel Blade Snippets** : Raccourcis pour Blade
- **Laravel Artisan** : Commandes Laravel intégrées
- **GitLens** : Historique git avancé

### **⚙️ Configuration VS Code**
Créez `.vscode/settings.json` pour personnaliser :
```json
{
  "php.suggest.basic": false,
  "php.validate.executablePath": "/usr/local/bin/php",
  "files.associations": {
    "*.blade.php": "blade"
  }
}
```

---

## 🚨 **Troubleshooting Codespace**

### **❌ Problèmes Courants**

#### **Port 8000 non accessible**
```bash
# Vérifiez que le serveur tourne
ps aux | grep artisan

# Redémarrez si nécessaire
php artisan serve --host=0.0.0.0 --port=8000
```

#### **Erreur de permissions SQLite**
```bash
# Recréez la base avec les bonnes permissions
rm database/database.sqlite
touch database/database.sqlite
chmod 664 database/database.sqlite
php artisan migrate
```

#### **Extensions manquantes**
1. Ouvrez la palette de commandes (`Ctrl+Shift+P`)
2. Tapez "Extensions: Install Extensions"
3. Recherchez et installez "PHP Intelephense"

#### **Codespace lent**
- Les Codespaces gratuits ont des limitations de performance
- Fermez les onglets inutiles
- Utilisez `php artisan optimize` pour améliorer les performances

### **🔄 Réinitialisation Complète**
Si tout va mal :
```bash
# Réinitialisation de l'application
composer install
php artisan key:generate
php artisan migrate:fresh
php artisan optimize:clear
```

---

## 💰 **Quotas et Limitations**

### **🆓 Compte Gratuit GitHub**
- **120 heures/mois** de Codespace gratuit
- **15 GB** de stockage
- **2-core machines** (performance limitée)

### **🎓 GitHub Education**
Si vous avez GitHub Student Pack :
- **180 heures/mois** supplémentaires
- Accès à des machines plus puissantes

### **⏰ Gestion du Quota**
- Le Codespace s'arrête automatiquement après **30 min d'inactivité**
- Fermez les Codespaces inutilisés via [github.com/codespaces](https://github.com/codespaces)
- Surveillez votre usage dans les paramètres GitHub

---

## 🎯 **Bonnes Pratiques Codespace**

### **✅ À Faire**
- Utilisez le Codespace pour les séances de formation
- Sauvegardez régulièrement avec `git commit`
- Fermez le Codespace quand vous ne l'utilisez pas
- Utilisez les raccourcis VS Code pour être efficace

### **❌ À Éviter**
- Laisser le Codespace tourner H24
- Installer des logiciels lourds non nécessaires
- Stocker des fichiers personnels sensibles
- Oublier de commit vos modifications

---

## 🆚 **Codespace vs Installation Locale**

| Critère | GitHub Codespace | Installation Locale |
|---------|------------------|-------------------|
| **Installation** | ✅ Aucune (30s) | ⚠️ PHP, Composer, IDE (30 min) |
| **Performance** | ⚠️ Dépend d'internet | ✅ Performance native |
| **Uniformité** | ✅ Identique pour tous | ⚠️ Peut varier |
| **Coût** | ⚠️ Quota limité | ✅ Gratuit illimité |
| **Accessibilité** | ✅ Partout avec internet | ⚠️ Un seul ordinateur |
| **Collaboration** | ✅ Partage facile | ⚠️ Plus complexe |

### **🎯 Recommandation**
- **Codespace** : Idéal pour débuter et les séances de formation
- **Local** : Mieux pour le développement intensif et les projets longs

---

## 📚 **Ressources Complémentaires**

### **📖 Documentation Officielle**
- [GitHub Codespaces Docs](https://docs.github.com/en/codespaces)
- [Laravel Documentation](https://laravel.com/docs)
- [VS Code in Browser](https://code.visualstudio.com/docs/remote/codespaces)

### **🎥 Tutoriels Vidéo**
- [Introduction aux Codespaces](https://www.youtube.com/watch?v=ozuDPmcC1io)
- [Laravel in Codespaces](https://laracasts.com/series/setup-laravel-codespace)

### **🤝 Support Communauté**
- [GitHub Community](https://github.community/c/codespaces)
- [Laravel Discord](https://discord.gg/laravel)

---

**🎉 Prêt à développer BiblioTech dans le cloud avec GitHub Codespace !**

> 💡 **Conseil** : Bookmarkez l'URL de votre Codespace pour un accès rapide lors des prochaines séances !

---

*✨ GitHub Codespace - Laravel 12 - Formation BTS SIO SLAM - 2025*