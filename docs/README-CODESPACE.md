# 🌐 BiblioTech sur GitHub Codespaces

> Guide rapide pour utiliser BiblioTech dans un environnement Codespaces

---

## 🚀 Démarrage Rapide (30 secondes)

1. **Créer le Codespace** : Cliquez sur "Code" → "Codespaces" → "Create codespace on main"
2. **Attendez l'initialisation** : Les dépendances et la base de données s'installent automatiquement
3. **Accédez à l'application** : 
   - Onglet **PORTS** (en bas)
   - Cliquez sur l'icône **🌐** du port 8000

**✅ C'est tout ! Votre application est prête.**

---

## 📁 Documentation Complète

| Guide | Description | Lien |
|-------|-------------|------|
| 📖 **Installation Codespace** | Guide complet d'installation et utilisation | [INSTALLATION-CODESPACE.md](INSTALLATION-CODESPACE.md) |
| 🌐 **Accès Application** | Comment accéder à l'app via les ports | [ACCES-CODESPACE.md](../ACCES-CODESPACE.md) |
| 🚨 **Dépannage URLs** | Résoudre les problèmes de redirection localhost | [CODESPACE-TROUBLESHOOTING.md](CODESPACE-TROUBLESHOOTING.md) |

---

## 🎯 Accès à l'Application

### Méthode 1️⃣ : Onglet PORTS (Recommandé)

1. En bas de VS Code, cliquez sur **PORTS**
2. Trouvez le port **8000**
3. Cliquez sur l'icône **🌐** (globe)

### Méthode 2️⃣ : URL Directe

Votre URL Codespaces ressemble à :
```
https://[nom-du-codespace]-8000.app.github.dev
```

Exemple :
```
https://cuddly-eureka-9jw7r7j4jwhpr5-8000.app.github.dev/livres
```

### Méthode 3️⃣ : Simple Browser (Intégré VS Code)

1. **CTRL+SHIFT+P** (ou CMD+SHIFT+P sur Mac)
2. Tapez : **Simple Browser: Show**
3. URL : `http://localhost:8000/livres`

---

## 🔧 Configuration Automatique

Le projet BiblioTech configure automatiquement :

✅ **Détection Codespaces** : Laravel détecte automatiquement l'environnement Codespaces  
✅ **URLs Correctes** : Les liens utilisent automatiquement l'URL Codespaces  
✅ **HTTPS Forcé** : Redirection automatique vers HTTPS  
✅ **Proxy Trust** : Configuration des headers de forwarding  

### Fichiers Configurés

| Fichier | Configuration |
|---------|---------------|
| `.devcontainer/devcontainer.json` | Configuration du conteneur et post-installation |
| `bootstrap/app.php` | Détection Codespaces et configuration proxy |
| `app/Providers/AppServiceProvider.php` | Force HTTPS et URL racine |
| `.env` | APP_URL dynamique basé sur Codespaces |

---

## 🛠️ Commandes Utiles

### Redémarrer le Serveur

```bash
# Script automatique (recommandé)
bash restart-server.sh

# Ou manuellement
pkill -f "artisan serve"
php artisan serve --host=0.0.0.0 --port=8000
```

### Vérifier le Serveur

```bash
# Vérifier le port 8000
ss -ltnp | grep :8000

# Doit afficher : 0.0.0.0:8000 (PAS 127.0.0.1:8000)
```

### Nettoyer les Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

### Voir les Routes

```bash
php artisan route:list
```

### Tester la Base de Données

```bash
php artisan tinker --execute="echo 'Livres: ' . \App\Models\Livre::count();"
```

---

## ⚠️ Problèmes Courants

### ❌ "Ce site est inaccessible"

**Cause** : Vous utilisez `http://localhost:8000` au lieu de l'URL Codespaces

**Solution** : 
- Utilisez l'onglet **PORTS** et cliquez sur l'icône 🌐
- OU utilisez l'URL `https://[codespace]-8000.app.github.dev`

### ❌ Les liens pointent vers localhost

**Cause** : Configuration URL incorrecte ou cache Laravel

**Solution** :
```bash
bash restart-server.sh
```

📖 **Guide complet** : [CODESPACE-TROUBLESHOOTING.md](CODESPACE-TROUBLESHOOTING.md)

### ❌ Port 8000 déjà utilisé

**Cause** : Un ancien serveur tourne encore

**Solution** :
```bash
pkill -9 -f "artisan serve"
php artisan serve --host=0.0.0.0 --port=8000
```

### ❌ Erreur 500 ou page blanche

**Cause** : Cache Laravel ou erreur configuration

**Solution** :
```bash
php artisan optimize:clear
tail -50 storage/logs/laravel.log
```

---

## 📊 Différences Codespaces vs Local

| Aspect | Codespaces | Local |
|--------|------------|-------|
| **URL** | `https://[codespace]-8000.app.github.dev` | `http://localhost:8000` |
| **Serveur** | `0.0.0.0:8000` (toutes interfaces) | `127.0.0.1:8000` (localhost) |
| **HTTPS** | Forcé automatiquement | HTTP par défaut |
| **Proxy** | Headers X-Forwarded-* requis | Non nécessaire |
| **APP_URL** | Dynamique (détecté auto) | Statique (localhost) |

---

## 🎓 Bonnes Pratiques

### ✅ À Faire

- **Utilisez l'onglet PORTS** pour ouvrir l'application
- **Bookmarkez l'URL** Codespaces pour un accès rapide
- **Fermez le Codespace** quand vous ne l'utilisez pas (économie quota)
- **Commitez régulièrement** vos changements
- **Utilisez `restart-server.sh`** pour redémarrer proprement

### ❌ À Éviter

- Ne tapez **PAS** `localhost:8000` dans votre navigateur externe
- N'éditez **PAS** manuellement `APP_URL` (détection automatique)
- Ne laissez **PAS** le Codespace tourner H24
- N'oubliez **PAS** de tester localement avant de commit

---

## 🔍 Variables d'Environnement Codespaces

Laravel détecte automatiquement ces variables :

```bash
$CODESPACE_NAME           # Nom unique du Codespace
$GITHUB_CODESPACE_TOKEN   # Token d'authentification
$GITHUB_USER              # Votre nom d'utilisateur GitHub
```

Vérifier :
```bash
echo $CODESPACE_NAME
# Affiche : cuddly-eureka-9jw7r7j4jwhpr5
```

---

## 📚 Ressources Complémentaires

- 📖 [Documentation Laravel](https://laravel.com/docs)
- 🌐 [GitHub Codespaces Docs](https://docs.github.com/en/codespaces)
- 🎓 [BiblioTech - Guide Complet](../README.md)
- 🛠️ [Dépannage Codespaces](CODESPACE-TROUBLESHOOTING.md)

---

## 💡 Astuces Productivité

### Raccourcis Clavier VS Code

- **CTRL+`** : Ouvrir/fermer le terminal
- **CTRL+SHIFT+P** : Palette de commandes
- **CTRL+B** : Afficher/masquer la sidebar
- **ALT+↑/↓** : Déplacer une ligne

### Extensions Recommandées

Installées automatiquement dans le Codespace :
- ✅ PHP Intelephense (autocomplétion PHP)
- ✅ Laravel Blade Snippets (raccourcis Blade)
- ✅ Laravel Artisan (commandes Laravel intégrées)

### Scripts Personnalisés

Créez vos propres alias dans `~/.bashrc` :

```bash
alias art='php artisan'
alias serve='php artisan serve --host=0.0.0.0 --port=8000'
alias fresh='php artisan migrate:fresh --seed'
```

---

## ⏱️ Gestion du Quota Codespaces

### Compte Gratuit
- **120h/mois** d'utilisation
- **15 GB** de stockage
- **2-core** machines

### Optimisation
- ✅ Codespace s'arrête après **30 min** d'inactivité (automatique)
- ✅ Fermez manuellement via [github.com/codespaces](https://github.com/codespaces)
- ✅ Supprimez les Codespaces inutilisés

### Vérifier le Quota
[github.com/settings/billing](https://github.com/settings/billing)

---

## 🎉 Prêt à Coder !

Votre environnement BiblioTech Codespaces est configuré et fonctionnel.

**Prochaines étapes :**
1. Ouvrez l'application via l'onglet PORTS
2. Testez les routes `/livres` et `/livre/1`
3. Consultez [docs/seance-03](seance-03/) pour les exercices

**Bon développement ! 🚀**

---

*Dernière mise à jour : Novembre 2025 - BiblioTech Laravel 12*
