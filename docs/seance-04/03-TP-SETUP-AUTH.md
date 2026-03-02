# 🔑 TP 1 - Setup du Système d'Authentification

**Durée estimée:** 45 minutes
**Prérequis:** Séance 3 complétée

---

## 🎯 Objectif

Mettre en place la structure complète du système d'authentification Laravel avec rôles.

---

## Étape 1: Vérifiez la table users

### Migration existante
```bash
# Les migrations existent déjà
php artisan migrate
```

### Vérifier la table
```php
php artisan tinker
>>> User::count()
0  # OK, table vide
```

---

## Étape 2: Configurer le modèle User

**Fichier:** `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isBibliothécaire()
    {
        return $this->role === 'bibliothécaire';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}
```

---

## Étape 3: Créer le contrôleur d'authentification

**Fichier:** `app/Http/Controllers/AuthController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Afficher formulaire login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Traiter login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Identifiants invalides']);
    }

    // Afficher formulaire inscription
    public function showRegister()
    {
        return view('auth.register');
    }

    // Traiter inscription
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user', // Rôle par défaut
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
```

---

## Étape 4: Configurer les routes

**Fichier:** `routes/web.php`

```php
use App\Http\Controllers\AuthController;

// Routes auth publiques
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Routes admin uniquement
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
```

---

## Étape 5: Créer le middleware de rôle

**Fichier:** `app/Http/Middleware/CheckRole.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);
        }

        abort(403, 'Non autorisé');
    }
}
```

**Enregistrer dans:** `app/Http/Kernel.php`

```php
protected $routeMiddleware = [
    // ... autres middleware
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

---

## Étape 6: Tester la configuration

```bash
# En Tinker
php artisan tinker

# Créer un admin
>>> $admin = User::create([
  'name' => 'Admin Test',
  'email' => 'admin@example.com',
  'password' => Hash::make('password'),
  'role' => 'admin'
])

# Vérifier
>>> $admin->isAdmin()
true

# Vérifier password
>>> Hash::check('password', $admin->password)
true

# Se connecter
>>> Auth::login($admin)
>>> Auth::user()->name
"Admin Test"
```

---

## ✅ Checklist de Validation

- [ ] Table users migrée
- [ ] Modèle User configuré avec méthodes rôles
- [ ] Contrôleur AuthController créé
- [ ] Routes auth configurées
- [ ] Middleware CheckRole créé
- [ ] Test Tinker réussi

---

Prêt pour les formulaires ? → [04-TP-FORMULAIRES-AUTH.md](04-TP-FORMULAIRES-AUTH.md)
