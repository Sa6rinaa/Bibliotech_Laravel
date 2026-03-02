# 📊 Évaluation de Compétences - Séance 4

**Durée estimée:** 2 heures (auto-évaluation + exercices)

---

## 🎯 Objectifs Évalués

- ✅ Vérifier compréhension authentification/autorisation
- ✅ Vérifier implémentation middleware
- ✅ Vérifier système de rôles
- ✅ Tester application en production

---

## 🚦 Auto-Évaluation (Avant l'évaluation formelle)

### Niveau 1️⃣ - Authentification Basique (Essentiel)

**Je dois pouvoir faire :**
- [ ] Expliquer la différence entre `Auth::attempt()` et `Auth::login()`
- [ ] Créer une page login qui fonctionne
- [ ] Vérifier qu'un utilisateur est connecté avec `auth()`
- [ ] Hasher un mot de passe avec `Hash::make()`
- [ ] Vérifier un mot de passe avec `Hash::check()`

**Si vous avez ❌ à plus de 2 questions:**
→ Relire [01-CONCEPTS-AUTH.md](01-CONCEPTS-AUTH.md) et [03-TP-SETUP-AUTH.md](03-TP-SETUP-AUTH.md)

---

### Niveau 2️⃣ - Rôles & Middleware (Important)

**Je dois pouvoir faire :**
- [ ] Créer un middleware de vérification de rôle
- [ ] Protéger une route avec `middleware(['auth', 'role:admin'])`
- [ ] Vérifier le rôle en contrôleur : `auth()->user()->role === 'admin'`
- [ ] Afficher/masquer du contenu en Blade selon le rôle
- [ ] Afficher un message d'erreur 403 si non autorisé

**Si vous avez ❌ à plus de 2 questions:**
→ Relire [02-GLOSSAIRE-AUTH.md](02-GLOSSAIRE-AUTH.md) et [04-TP-FORMULAIRES-AUTH.md](04-TP-FORMULAIRES-AUTH.md)

---

### Niveau 3️⃣ - Sécurité Avancée (Bonus)

**Je dois pouvoir faire :**
- [ ] Expliquer une attaque CSRF
- [ ] Ajouter `@csrf` dans un formulaire
- [ ] Implémenter un rate limiting  
- [ ] Logger les tentatives échouées
- [ ] Mettre en place une vérification d'email

**Si vous avez ❌ à plus de 3 questions:**
→ Extensions optionnelles, pour aller plus loin

---

## 📝 Partie 1: Questions Théoriques (30 min)

### Question 1 - Concepts (4 points)
**Expliquez la différence entre `Auth::attempt()` et `Auth::login()`**

Réponse attendue:
- `Auth::attempt()` vérifie les credentials puis crée la session
- `Auth::login()` crée la session sans vérifier (pour tests)

### Question 2 - Middleware (4 points)
**Comment protéger une route pour les admins seulement ?**

Réponse attendue:
```php
Route::middleware(['auth', 'role:admin'])->group(function () { ... });
```

### Question 3 - Hashage (4 points)
**Pourquoi ne jamais stocker les passwords en clair ?**

Réponse attendue:
- Si base compromise = tous les comptes compromis
- Hash = irréversible = plus sûr
- Utiliser bcrypt ou argon2

### Question 4 - Sessions (4 points)
**Comment fonctionne une session entre deux requêtes HTTP ?**

Réponse attendue:
- Login crée session_id envoyé dans cookie
- Chaque requête envoie le cookie
- Laravel retrouve les données de session

### Question 5 - Sécurité (4 points)
**Qu'est-ce qu'une protection CSRF et comment Laravel la gère ?**

Réponse attendue:
- CSRF = attaque par formulaire falsifié
- Laravel ajoute token CSRF dans forms
- `@csrf` dans Blade ajoute le token

---

## 💻 Partie 2: Exercice Pratique (45 min)

### Exercice: Système d'Authentification Complet

**Livrable attendu:**
1. Login/Register fonctionnels ✅
2. 3 rôles implémentés ✅
3. Dashboard personnalisé par rôle ✅
4. Routes protégées ✅
5. Formulaire modification profil ✅

### Critères d'acceptation

**Fonctionnalité** | **Points** | **Status**
---|---|---
Login avec email/password | 10 | ✅/❌
Register avec validation | 10 | ✅/❌
Système 3 rôles | 15 | ✅/❌
Dashboard personnalisé | 10 | ✅/❌
Routes middlewares | 10 | ✅/❌
Profil modification | 10 | ✅/❌
Sécurité CSRF | 10 | ✅/❌
Tests manuels | 15 | ✅/❌

**Total: 100 points**

---

## ✅ Checklist de Validation

- [ ] Table users dans DB
- [ ] Auth facade fonctionne
- [ ] Login/Register formulaires en place
- [ ] Middleware CheckRole fonctionnelle
- [ ] Dashboard affiche infos user
- [ ] Routes protégées (essayer sans auth)
- [ ] Logout fonctionne
- [ ] Tests unitaires passent

### Tester en Tinker

```bash
php artisan tinker

# Créer des users avec rôles différents
>>> User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => Hash::make('password'), 'role' => 'admin'])
>>> User::create(['name' => 'Biblio', 'email' => 'biblio@test.com', 'password' => Hash::make('password'), 'role' => 'bibliothécaire'])
>>> User::create(['name' => 'User', 'email' => 'user@test.com', 'password' => Hash::make('password'), 'role' => 'user'])

# Vérifier les méthodes
>>> $admin = User::first()
>>> $admin->isAdmin()
true
>>> $admin->isBibliothécaire()
false
```

---

## � Extensions à Implémenter

### Extension 1: Permissions Granulaires
Remplacer le simple système `role` par un système `roles & permissions`

**Concept:** Chaque rôle a des permissions (delete-user, edit-post, etc)

```php
// Admin peut avoir : delete-user, edit-user, view-logs
// Bibliothécaire peut avoir : add-livre, edit-livre
// User a : view-livre
```

**À implémenter dans [solutions/seance-04/](../../solutions/seance-04/)**

---

### Extension 2: Audit Logging
Logger toutes les actions sensibles (login failed, delete user, etc)

```php
// Log chaque tentative de connexion échouée
// Log chaque suppression d'utilisateur
// Voir l'historique des actions par utilisateur
```

---

### Extension 3: Two-Factor Authentication (2FA)
Ajouter un code OTP par SMS/Email

```php
// L'utilisateur se connecte
// Reçoit un code OTP
// Entre le code pour accéder
```

---

### Extension 4: Email Verification
Vérifier que l'adresse email existe

```php
// À l'inscription, envoyer un lien de vérification
// Bloquer l'accès jusqu'à vérification
// Relancer l'email si expiré
```

---

### Extension 5: Session Management
Gérer les sessions actives par utilisateur

```php
// Voir toutes les sessions ouvertes
// Fermer les autres sessions
// Timeout après 30 min d'inactivité
```

---

## 📋 Notation

| Score | Évaluation | Compétences |
|-------|-----------|-------------|
| 80-100 | Excellent | Auth + Rôles + Middleware + Sécurité + 2+ Extensions |
| 60-79 | Bon | Auth + Rôles + Middleware + Sécurité |
| 40-59 | Satisfaisant | Auth + Rôles + Middleware |
| 0-39 | À revoir | Manque des éléments clés |

---

## 🏆 Compétences Validées

### Niveau 1 - Fondation ✅
- ✅ Principes d'authentification
- ✅ Hashage sécurisé des passwords

### Niveau 2 - Intermédiaire ✅
- ✅ Implémentation Laravel Auth
- ✅ Gestion des rôles
- ✅ Middleware protection


### Niveau 3 - Avancé ✅
- ✅ Sécurité des applications web (CSRF, Rate limiting)
- ✅ Système de sessions
- ✅ Gestion complète des utilisateurs

### Niveau 4 - Expert 🚀
- 🚀 Permissions granulaires
- 🚀 Audit logging
- 🚀 Two-Factor Authentication
- 🚀 Email verification

---

## 📚 Ressources Complètes

- [Solution Complète](../../solutions/seance-04/README.md) avec explications
- [Laravel Auth Officiel](https://laravel.com/docs/11.x/authentication)
- [Middleware](https://laravel.com/docs/11.x/middleware)
- [Authorization](https://laravel.com/docs/11.x/authorization)

---

Prêt pour la séance 5 ? 🚀 → [docs/seance-05/00-README.md](../seance-05/00-README.md)
