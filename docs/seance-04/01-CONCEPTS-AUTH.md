# 🧠 Concepts Fondamentaux - Séance 04

Authentification et Autorisations dans Laravel

---

## 📚 Table des matières

1. [Authentification vs Autorisation](#authentification-vs-autorisation)
2. [Système de Sessions](#système-de-sessions)
3. [Hashage des Mots de Passe](#hashage-des-mots-de-passe)
4. [Middleware de Protection](#middleware-de-protection)
5. [Rôles et Permissions](#rôles-et-permissions)

---

## Authentification vs Autorisation

### **Authentification** 🔑
L'authentification vérifie **QUI ÊTES-VOUS**

```
Utilisateur                    Laravel
    ↓                          ↓
Email: user@example.com → Vérifier dans DB
Password: secret123     → Vérifier hash
                        ↓
                    Si OK: Créer session
```

### **Autorisation** 🛡️
L'autorisation vérifie **POUVEZ-VOUS FAIRE CECI**

```
Utilisateur              Middleware
    ↓                        ↓
Je veux accéder à /admin ← Vérifier rôle
Je veux modifier un user  ← Vérifier permission
                        ↓
                    Si OK: Accès accordé
                    Si NON: 403 Forbidden
```

---

## Système de Sessions

### **Comment fonctionnent les sessions ?**

**1. Après le login :**
```
User.login(@email, @password)
    ↓
Check credentials in DB
    ↓
Valid → Create session_id (random token)
    ↓
Send session_id in cookie
    ↓
User browser saves cookie
```

**2. À chaque requête :**
```
Browser sends cookie with session_id
    ↓
Laravel reads session_id from cookie
    ↓
Retrieve sessions data from storage
    ↓
Auth::user() returns current user
```

**3. Stockage des sessions (3 choix) :**

```php
// 1. En fichier (par défaut) - Simple développement
SESSION_DRIVER=file

// 2. En base de données - Production
SESSION_DRIVER=database

// 3. En mémoire avec Redis - Haute performance
SESSION_DRIVER=redis
```

### **Configuration dans .env**
```env
SESSION_DRIVER=file                 # Stockage
SESSION_LIFETIME=120                # 120 minutes
SESSION_COOKIE=XSRF-TOKEN          # Nom du cookie
SESSION_PATH=/                      # Chemin
COOKIE_DOMAIN=null                  # Domaine
```

---

## Hashage des Mots de Passe

### **Pourquoi hasher ?**

❌ **JAMAIS chercher un mot de passe en clair**
```php
// DANGEREUX - Jamais faire ça !
$user = User::where('email', $email)
            ->where('password', $password)  // ❌ JAMAIS!
            ->first();
```

✅ **TOUJOURS hasher**
```php
// BON - Hasher et vérifier
$user = User::where('email', $email)->first();
if (Hash::check($password, $user->password)) {
    // Correct !
}
```

### **Algorithme Bcrypt**

```
Password en clair: "secret123"
         ↓
    Bcrypt (salt + hash)
         ↓
Stocké: "$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/eMe"
(stocker ça en DB, jamais le mot de passe)
         ↓
Login avec "secret123"
    ↓
Hash::check("secret123", hash_stocké)
    ↓
TRUE = Authentification réussie
```

### **En Laravel Code**
```php
// Enregistrement - hasher automatiquement
$user = User::create([
    'email' => 'user@example.com',
    'password' => Hash::make('secret123'),  // Automtique parfois
]);

// Vérification - lors du login
if (Hash::check($inputPassword, $user->password)) {
    // Connexion Ok
    Auth::login($user);
}
```

---

## Middleware de Protection

### **Qu'est-ce qu'un middleware ?**

Un middleware est un **filtre** qui s'exécute AVANT que votre contrôleur ne reçoive la requête.

```
Requête HTTP
    ↓
Middleware 1 (vérifier CSRF)
    ↓
Middleware 2 (vérifier auth)
    ↓
Middleware 3 (vérifier rôle)
    ↓
Contrôleur
    ↓
Réponse
```

### **Middleware d'Authentification**

```php
// routes/web.php
Route::get('/dashboard', [DashboardController::class, 'show'])
    ->middleware('auth');
    // Si pas authentifié: redirection vers login
```

### **Middleware de Rôle Personnalisé**

```php
// app/Http/Middleware/CheckRole.php
class CheckRole {
    public function handle($request, Closure $next, $role) {
        if (Auth::user()->role !== $role) {
            abort(403, 'Non autorisé');
        }
        return $next($request);
    }
}

// Utilisation
Route::get('/admin', [AdminController::class, 'show'])
    ->middleware('auth', 'role:admin');
```

### **Middleware disponibles dans Laravel**

| Middleware | Fonction |
|-----------|----------|
| `auth` | Vérifier authentification |
| `guest` | Vérifier non-authentifié |
| `role:admin` | Vérifier rôle |
| `throttle` | Limiter requêtes |
| `can:permission` | Vérifier permission |

---

## Rôles et Permissions

### **Rôles dans BiblioTech**

```sql
role ENUM('admin', 'bibliothécaire', 'user')

-- Admin : Accès total
-- Bibliothécaire : Gère le catalogue
-- User : Accès consultation et emprunts
```

### **Table de mapping rôles**

```
┌────────────────────────────────────┐
│ Rôle           │ Accès             │
├────────────────────────────────────┤
│ admin          │ Tout              │
│ bibliothécaire │ CRUD livres       │
│ user           │ Lecture + emprunts│
└────────────────────────────────────┘
```

### **Vérifier les rôles**

```php
// Dans le code
if (Auth::user()->role === 'admin') {
    // Afficher options admin
}

// Dans les templates Blade
@if(Auth::user()->role === 'admin')
    <a href="/admin">Admin Panel</a>
@endif

// Dans les routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::delete('/users/{id}', [AdminController::class, 'delete']);
});
```

---

## 🔄 Flux Complet d'Authentification

```
┌─────────────────────────────────────────┐
│          Page de Login                   │
│  Form: email, password, remember_me     │
└─────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────┐
│  POST /login (LoginController@store)     │
│  - Valider données                       │
│  - Chercher user par email               │
│  - Vérifier password avec Hash::check    │
└─────────────────────────────────────────┘
           ↓
     ┌──────────┬──────────┐
     ↓          ↓
  VALIDE    INVALIDE
     ↓          ↓
  Auth::     Flash erreur
  login()    Redirection
     ↓        login
  Cookie
  session
     ↓
  Redirection
  dashboard
     ↓
┌─────────────────────────────────────────┐
│  GET /dashboard (@middleware auth)       │
│  - Session existante                     │
│  - Auth::user() retourne user            │
│  - Affiche contenu                       │
└─────────────────────────────────────────┘
```

---

## 🎯 Points Clés à Retenir

✅ **Authentification** = Vérifier identité (login)
✅ **Autorisation** = Vérifier permissions (rôles)
✅ **Session** = Garder user connecté
✅ **Hash** = Hasher toujours les passwords
✅ **Middleware** = Protéger les routes
✅ **Rôles** = Contrôler l'accès par niveau

---

## 📝 Exercice de Compréhension

### Question 1
Quelle est la différence entre authentification et autorisation?

**Réponse:** 
- Authentification = Qui êtes-vous ? (login)
- Autorisation = Pouvez-vous faire ceci ? (rôles)

### Question 2
Pourquoi ne pas stocker les mots de passe en clair?

**Réponse:** 
Si la base est compromise, l'attaquant a accès à tous les comptes. Avec un hash, il ne peut pas retrouver le mot de passe original.

### Question 3
Comment Laravel sait-il sauvegarder qui est connecté?

**Réponse:**
Via une session avec un cookie contenant un session_id. À chaque requête, Laravel retrouve les données de session avec ce token.

---

Prêt pour les TP ? 📝 → [03-TP-SETUP-AUTH.md](03-TP-SETUP-AUTH.md)
