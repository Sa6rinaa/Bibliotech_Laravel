# 💪 TP 3 - Exercices Pratiques & Intégration

**Durée estimée:** 90 minutes

---

## 🎯 Exercice 1: Système de Rôles Avancé

Implémenter la logique complète des 3 rôles : admin, bibliothécaire, user

### Tâche
Créer une page `/utilisateurs` où:
- **Admin** voit tous les users avec options d'édition/suppression
- **Bibliothécaire** voit que ses stats
- **User** n'a pas accès

### Code attendu

```php
// Dans routes/web.php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/utilisateurs', [UserController::class, 'index']);
    Route::delete('/utilisateurs/{id}', [UserController::class, 'delete']);
    Route::patch('/utilisateurs/{id}/role', [UserController::class, 'updateRole']);
});
```

---

## 🎯 Exercice 2: Protections CSRF et Validations

Ajouter validation complète des formulaires auth

### Tâche
Améliorer le login pour :
- Limiter les tentatives (throttle)
- Log les tentatives échouées
- Vérifier email confirmé (optionnel)

### Code

```php
// routes/web.php
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')  // 5 tentatives par minute
    ->name('login');

// Dans AuthController
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email|exists:users',
        'password' => 'required|min:8',
    ]);

    if (!Auth::attempt($credentials)) {
        Log::warning('Login failed', ['email' => $request->email]);
        return back()->withErrors(['email' => 'Identifiants invalides']);
    }

    return redirect('/dashboard');
}
```

---

## 🎯 Exercice 3: Modification de Profil

Créer une page `/profile` pour modifier les données du user

### Tâche
Implémenter :
- Modifier nom/email
- Changer mot de passe
- Supprimer compte (soft delete optionnel)

### Fichier: `app/Http/Controllers/ProfileController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($validated);
        return redirect('/profile')->with('success', 'Profil mis à jour');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe incorrect']);
        }

        auth()->user()->update(['password' => Hash::make($validated['password'])]);
        return back()->with('success', 'Mot de passe changé');
    }
}
```

---

## 🎯 Exercice 4: Tests Unitaires

Créer des tests pour vérifier l'authentification

### Code: `tests/Feature/AuthTest.php`

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $response->assertRedirect('/dashboard');
    }

    public function test_user_can_login()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_view_users()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/utilisateurs');
        $response->assertStatus(200);
    }
}
```

---

## 🎯 Exercice 5: Intégration Complète

Préparer l'app complète avec tous les éléments

### Checklist

- [ ] Users table avec rôles
- [ ] Authentification (login/register/logout)
- [ ] Middleware de rôle
- [ ] Dashboard personnalisé par rôle
- [ ] Formulaires de modification
- [ ] Sécurité CSRF
- [ ] Tests unitaires
- [ ] Messages succès/erreur
- [ ] Navigation navbar mise à jour
- [ ] Logout depuis tous les navigateurs aussi

---

## 📋 Validation Finale

Exécutez ces commandes :

```bash
# Tests
php artisan test

# Linter
php artisan code:analyse  # Si disponible

# Vérifier structure
php artisan tinker
>>> User::count()
>>> User::where('role', 'admin')->count()
>>> Auth::user()
```

---

Prêt pour l'évaluation ? → [06-EVALUATION-COMPETENCES.md](06-EVALUATION-COMPETENCES.md)
