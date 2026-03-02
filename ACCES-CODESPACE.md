# 🌐 Guide d'Accès à BiblioTech sur Codespaces

## ✅ Statut du Serveur

- **Serveur Laravel** : ✅ EN COURS D'EXÉCUTION
- **Port** : 8000
- **Base de données** : ✅ 6 livres disponibles
- **Codespace** : `cuddly-eureka-9jw7r7j4jwhpr5`

---

## 🎯 Comment Accéder à l'Application

### Méthode 1 : Via l'Onglet PORTS (RECOMMANDÉ)

1. **En bas de VS Code**, cliquez sur l'onglet **"PORTS"**
2. **Trouvez la ligne du port 8000**
3. **Dans la colonne "Forwarded Address"**, vous verrez une URL comme :
   ```
   https://cuddly-eureka-9jw7r7j4jwhpr5-8000.app.github.dev
   ```
4. **Cliquez sur l'icône 🌐** (globe) ou **CTRL+Clic** sur l'URL

### Méthode 2 : Clic Droit sur le Port

1. Allez dans l'onglet **PORTS**
2. **Clic droit** sur le port 8000
3. Sélectionnez **"Open in Browser"**

### Méthode 3 : Simple Browser (VS Code Intégré)

1. Appuyez sur **CTRL+SHIFT+P** (ou CMD+SHIFT+P sur Mac)
2. Tapez : **Simple Browser: Show**
3. Entrez l'URL : `http://localhost:8000/livres`

---

## 📋 URLs à Tester

Une fois que vous avez accès via l'onglet PORTS, testez ces routes :

```
/                    → Page d'accueil
/livres              → Liste des livres (6 livres)
/livre/1             → Dune (Frank Herbert)
/livre/2             → Guide Laravel
/livre/3             → Histoire de France
/livre/4             → Les Misérables
/livre/5             → Steve Jobs
/livre/6             → Le Seigneur des Anneaux
/recherche           → Recherche de livres
/test-debug          → Test simple Laravel
```

---

## 🔧 Visibilité du Port

Si l'URL ne fonctionne pas :

1. **Onglet PORTS** → Clic droit sur le port 8000
2. **Port Visibility** → Sélectionnez **"Public"**
3. Réessayez d'ouvrir le navigateur

---

## ⚠️ Erreurs Courantes

### "Ce site est inaccessible"

**Cause** : Vous utilisez `http://localhost:8000` dans votre navigateur externe

**Solution** : N'utilisez PAS localhost ! Utilisez l'URL Codespaces depuis l'onglet PORTS

### Port non visible

**Cause** : Le serveur n'écoute pas sur 0.0.0.0

**Solution** : Le serveur est déjà configuré correctement (vérifié)

### URL Codespaces ne répond pas

**Cause** : Visibilité du port en "Private"

**Solution** : Changez en "Public" (voir section Visibilité)

---

## 🧪 Tests de Vérification

Le serveur a été testé et **fonctionne** :

```bash
✅ curl http://127.0.0.1:8000/test-debug
   → Retourne : "Laravel fonctionne !"

✅ curl http://127.0.0.1:8000/livre/1
   → HTTP 200 OK (page complète)

✅ Base de données SQLite
   → 6 livres, 12 tables
```

---

## 📸 Capture d'Écran de l'Onglet PORTS

Cherchez cette section en bas de VS Code :

```
┌─────────────────────────────────────────────────┐
│ PROBLEMS | OUTPUT | DEBUG CONSOLE | TERMINAL    │
│ ► PORTS  | ► GITHUB PULL REQUEST | etc.        │
└─────────────────────────────────────────────────┘

Dans PORTS, vous verrez :
Port    | Label              | Forwarded Address
--------|-------------------|------------------
8000    | BiblioTech App    | https://cuddly-eureka-...
```

---

## 🆘 Besoin d'Aide ?

### 🔧 Problème d'URLs et Redirections ?

Si les liens pointent vers `localhost` au lieu de l'URL Codespaces, consultez :

**📖 [Guide Complet de Dépannage](docs/CODESPACE-TROUBLESHOOTING.md)**

Ce guide explique :
- ✅ Pourquoi les URLs ne fonctionnaient pas
- ✅ Les modifications apportées (`.env`, `bootstrap/app.php`)
- ✅ Comment Laravel détecte automatiquement Codespaces
- ✅ Scripts de redémarrage automatique

### ⚡ Solutions Rapides

Si rien ne fonctionne :

1. **Redémarrez le serveur proprement** :
   ```bash
   bash restart-server.sh
   ```

2. **Vérifiez le port** :
   ```bash
   ss -ltnp | grep :8000
   # Doit afficher : 0.0.0.0:8000
   ```

3. **Utilisez le Simple Browser intégré** (VS Code) :
   - CTRL+SHIFT+P → "Simple Browser: Show"
   - URL : `http://localhost:8000/livres`

---

**✨ Le serveur fonctionne ! Utilisez l'onglet PORTS pour y accéder.**
