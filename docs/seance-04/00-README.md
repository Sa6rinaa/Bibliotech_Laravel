# 🔐 Séance 4 — Authentification & Autorisations

Dernière mise à jour: Février 2026

Bienvenue dans la quatrième séance du parcours **BiblioTech BTS SIO SLAM**. Cette séance vous permettra de sécuriser votre application en implémentant une authentification robuste et un système de rôles.

---

## 🎯 Objectifs de la Séance

À l'issue de cette séance, vous serez capable de :

- ✅ **Implémenter l'authentification Laravel** (login/register)
- ✅ **Gérer les rôles et permissions** (Admin, Bibliothécaire, User)
- ✅ **Protéger les routes** avec middleware d'authentification
- ✅ **Créer des formulaires de login/registre** sécurisés
- ✅ **Gérer les sessions utilisateur** avec Laravel
- ✅ **Implémenter "Se souvenir de moi"** et logout
- ✅ **Sécuriser contre les attaques courantes** (CSRF, brute-force)

---

## 📂 Sommaire de la Séance

### **1. Concepts Clés**
📖 **[01-CONCEPTS-AUTH.md](01-CONCEPTS-AUTH.md)**
- Authentification vs Autorisation
- Système de sessions Laravel
- Hashage des mots de passe (bcrypt)
- Middleware de protection
- Rôles et permissions

### **2. Glossaire**
📖 **[02-GLOSSAIRE-AUTH.md](02-GLOSSAIRE-AUTH.md)**
- Terminologie d'authentification
- Commandes Artisan essentielles
- Fonctions d'aide Laravel

### **3. TP Setup Authentification**
🔑 **[03-TP-SETUP-AUTH.md](03-TP-SETUP-AUTH.md)**
- Installation du système d'authentification
- Création des contrôleurs Auth
- Migration des tables utilisateurs
- Configuration initiale

### **4. TP Implémentation Formulaires**
📝 **[04-TP-FORMULAIRES-AUTH.md](04-TP-FORMULAIRES-AUTH.md)**
- Création formulaire de registration
- Création formulaire de login
- Validation des entrées
- Messages d'erreur et succès

### **5. TP Pratique - Exercices**
💪 **[05-TP-PRATIQUE-EXERCICES.md](05-TP-PRATIQUE-EXERCICES.md)**
- Implémentation complète du système
- Système de rôles (Admin/Biblio/User)
- Protection des routes
- Tests manuels

### **6. Évaluation de Compétences**
📊 **[06-EVALUATION-COMPETENCES.md](06-EVALUATION-COMPETENCES.md)**
- Critères d'évaluation
- Contrôle des connaissances
- Validation des compétences acquises

---

## 🚀 Points Clés de cette Séance

### **Architecture d'Authentification**

```
User Registration
      ↓
Create User (hash password) → Store in DB
      ↓
User Login
      ↓
Verify credentials → Create session
      ↓
Protected Routes (middleware auth)
```

### **Modèle de Données - Table Users**

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    email_verified_at TIMESTAMP,
    password VARCHAR(255),
    role ENUM('admin', 'bibliothécaire', 'user'),
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)
```

### **Middleware d'Authentification**

```php
// Route protégée
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Vérifier le rôle
Route::get('/admin', function () {
    return view('admin');
})->middleware('auth', 'role:admin');
```

---

## 📚 Pré-requis

- ✅ Séance 3 complétée (Controllers & Views)
- ✅ Compréhension des migrations
- ✅ Notions de hachage et sécurité

---

## 🔧 Installation & Configuration

### **1. Vérifiez le fichier .env**
```bash
APP_DEBUG=true
APP_URL=http://localhost:8000
SESSION_DRIVER=file
```

### **2. Migrations de base déjà crées**
```bash
# La table users existe déjà dans les migrations
php artisan migrate
```

### **3. Vérifiez l'installation**
```bash
php artisan tinker
>>> User::count()
```

---

## ✅ Livrables à la fin de cette séance

- [x] Table users à jour avec champs rôle
- [x] Modèle User configuré
- [x] Contrôleur AuthController créé
- [x] Formulaires de login/register fonctionnels
- [x] Système de rôles implémenté
- [x] Routes protégées
- [x] Middleware de vérification en place

---

## 📖 Ressources Complètes

| Ressource | Type | Durée | Lien |
|-----------|------|-------|------|
| Concepts Auth | 📖 Course | 20 min | [01-CONCEPTS-AUTH.md](01-CONCEPTS-AUTH.md) |
| Glossaire Auth | 📚 Reference | 15 min | [02-GLOSSAIRE-AUTH.md](02-GLOSSAIRE-AUTH.md) |
| Setup Auth | 🎯 Lab | 30 min | [03-TP-SETUP-AUTH.md](03-TP-SETUP-AUTH.md) |
| Formulaires | 📝 Lab | 45 min | [04-TP-FORMULAIRES-AUTH.md](04-TP-FORMULAIRES-AUTH.md) |
| Exercices Pratiques | 💪 Hands-on | 60 min | [05-TP-PRATIQUE-EXERCICES.md](05-TP-PRATIQUE-EXERCICES.md) |
| Évaluation | 📊 Quiz | 30 min | [06-EVALUATION-COMPETENCES.md](06-EVALUATION-COMPETENCES.md) |

---

## 🎯 Progression Pédagogique

```
Séance 1: Routes & MVC
    ↓
Séance 2: Models & Database
    ↓
Séance 3: Controllers & Views
    ↓
Séance 4: Authentication & Roles ← Nous sommes ici
    ↓
Séance 5: Production & Deployment
```

---

## 💡 Conseils pour réussir

1. **Comprendre avant de coder** - Lisez les concepts en premier
2. **Suivre l'ordre des TP** - Le setup doit être avant les formulaires
3. **Tester à chaque étape** - Utilisez `php artisan tinker`
4. **Les erreurs sont des apprentissages** - Lisez les stacktraces
5. **Demander de l'aide** - Les formateurs sont là pour ça

---

Bon courage pour cette séance ! 🚀
