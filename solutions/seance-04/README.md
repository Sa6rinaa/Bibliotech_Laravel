# 🎓 Solution - Séance 4: Authentification & Autorisation

**Durée:** 8 heures  
**Compétences:** Auth, Middleware, Rôles & Permissions, Sécurité  

---

## 📁 Structure des Solutions

```
solutions/seance-04/
├── README.md (ce fichier)
├── app/Http/Controllers/
│   ├── AuthController.php
│   ├── UserController.php
│   └── ProfileController.php
├── app/Http/Middleware/
│   ├── CheckRole.php
│   └── AuditLog.php
├── routes/
│   └── web.php
├── resources/views/
│   ├── auth/
│   │   ├── login.blade.php
│   │   ├── register.blade.php
│   │   └── forgot-password.blade.php
│   ├── dashboard/
│   │   ├── admin.blade.php
│   │   ├── bibliothecaire.blade.php
│   │   └── user.blade.php
│   └── profile/
│       └── edit.blade.php
└── tests/Feature/
    └── AuthTest.php
```

---

## 🎯 Concepts Clés Appliqués

### 1️⃣ Authentification
- User identification (login/register)
- Hash passwords avec bcrypt
- Sessions HTTP
- Guard Laravel (user)

### 2️⃣ Autorisation
- Vérifier si user est connecté (`auth()`)
- Système de rôles (admin, bibliothecaire, user)
- Middleware pour protéger les routes

### 3️⃣ Middleware
- Exécuté avant/après la requête
- Vérifie les permissions
- Redirige si non autorisé

### 4️⃣ Sécurité
- CSRF protection (token)
- Password reset secure
- Rate limiting
- Audit logging

### 5️⃣ Gestion Profil
- Modification email/nom
- Changement mot de passe
- Suppression compte (soft delete)

---

## ✅ Auto-Évaluation

### Niveau 1 - Authentification Basique (Essentiel)
- [ ] Je comprends la différence entre `Auth::attempt()` et `Auth::login()`
- [ ] Je sais hasher un mot de passe avec `Hash::make()`
- [ ] Je sais vérifier un mot de passe avec `Hash::check()`
- [ ] Je comprends les sessions HTTP et les cookies
- [ ] Je sais utiliser `auth()` pour récupérer l'utilisateur
- [ ] Je sais redirecter si non authentifié

**Validation:** Créer une page login qui fonctionne

### Niveau 2 - Rôles & Middleware (Important)
- [ ] Je sais créer un middleware
- [ ] Je comprends le système de rôles (admin, user, etc)
- [ ] Je sais protéger une route avec middleware
- [ ] Je sais vérifier le rôle d'un utilisateur en vue
- [ ] Je sais afficher/masquer du contenu selon le rôle
- [ ] Je comprends comment fonctionnent les middlewares enchaînés

**Validation:** Admin voit /utilisateurs, autres non

### Niveau 3 - Sécurité Avancée (Bonus)
- [ ] Je sais ce qu'est une attaque CSRF
- [ ] Je sais protéger un formulaire avec `@csrf`
- [ ] Je sais implémenter un rate limiting
- [ ] Je sais logger les tentatives de connexion
- [ ] Je sais implémenter un password reset sécurisé
- [ ] Je comprends la double authentification (2FA)

**Validation:** Implémenter throttling sur login

---

## 🚀 Extensions Possibles

### Extension 1: Système de Permissions Granulaire
**Objectif:** Permissions détaillées plutôt que juste des rôles

**Migration:**
```php
Schema::create('permissions', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('description');
    $table->timestamps();
});

Schema::create('role_permission', function (Blueprint $table) {
    $table->foreignId('role_id')->constrained();
    $table->foreignId('permission_id')->constrained();
});
```

**Dans Model User:**
```php
class User extends Model
{
    public function hasPermission($permission)
    {
        return $this->role->permissions->contains('name', $permission);
    }
}
```

**Usage:**
```php
if (auth()->user()->hasPermission('delete-user')) {
    // Afficher le bouton supprimer
}
```

**Compétences:** RBAC (Role-Based Access Control), pivot tables

---

### Extension 2: Email Verification
**Objectif:** Vérifier que l'email existe vraiment

**Migration:**
```php
Schema::table('users', function (Blueprint $table) {
    $table->timestamp('email_verified_at')->nullable();
});
```

**Dans le controller register:**
```php
use Illuminate\Auth\Events\Registered;

User::create([
    'name' => $validated['name'],
    'email' => $validated['email'],
    'password' => Hash::make($validated['password']),
]);

event(new Registered($user));

return redirect('/email/verify')
    ->with('status', 'Verification link sent!');
```

**Middleware:**
```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', ...);
});
```

**Compétences:** Events, queues, email sending

---

### Extension 3: Password Reset Sécurisé
**Objectif:** Laisser l'utilisateur réinitialiser son mot de passe

**Migration:**
```php
Schema::create('password_resets', function (Blueprint $table) {
    $table->string('email')->index();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});
```

**Controller:**
```php
class PasswordResetController extends Controller
{
    public function sendReset(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withError('Email not found');
        }

        // Créer un token unique
        $token = Str::random(64);
        
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Envoyer l'email avec lien
        Mail::send('emails.reset', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
        });

        return back()->with('status', 'Reset link sent!');
    }
}
```

**Compétences:** Token management, emailing, sécurité

---

### Extension 4: Audit Logging
**Objectif:** Logger toutes les actions sensibles (login, delete, etc)

**Migration:**
```php
Schema::create('audit_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained();
    $table->string('action'); // 'login', 'delete_user', etc
    $table->string('model_type')->nullable();
    $table->unsignedBigInteger('model_id')->nullable();
    $table->json('changes')->nullable();
    $table->ipAddress();
    $table->timestamps();
});
```

**Middleware:**
```php
class AuditLog
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        AuditLogEntry::create([
            'user_id' => auth()->id(),
            'action' => $request->route()->getName(),
            'ip_address' => $request->ip(),
        ]);

        return $response;
    }
}
```

**Query:**
```php
// Voir toutes les actions de l'utilisateur #5
AuditLogEntry::where('user_id', 5)->get();

// Voir quand quelqu'un a supprimé l'utilisateur #3
AuditLogEntry::where('action', 'delete_user')
    ->where('model_id', 3)
    ->get();
```

**Compétences:** Observation pattern, middleware, logging

---

### Extension 5: Two-Factor Authentication (2FA)
**Objectif:** Sécurité supplémentaire avec code d'authentification

**Installation:**
```bash
composer require pragmarx/google2fa-laravel
```

**Migration:**
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('two_factor_secret')->nullable();
    $table->timestamp('two_factor_confirmed_at')->nullable();
});
```

**Enable 2FA:**
```php
$secret = app('pragmarx.google2fa')->generateSecretKey();
auth()->user()->update([
    'two_factor_secret' => $secret,
]);

// Générer QR code
$qrCode = QrCode::size(200)->generate(
    app('pragmarx.google2fa')->getQRCodeUrl(config('app.name'), auth()->user()->email, $secret)
);
```

**Vérifier le code:**
```php
$valid = app('pragmarx.google2fa')->verifyKey(
    auth()->user()->two_factor_secret,
    $request->code
);

if (!$valid) {
    return back()->withError('Invalid 2FA code');
}
```

**Compétences:** Packages tiers, cryptographie, UX sécurité

---

## 📊 Grille de Validation

| Compétence | Status | Points | Notes |
|---|---|---|---|
| Auth fonctionnelle | ✅/❌ | /3 | Login/Register/Logout |
| Système de rôles | ✅/❌ | /3 | Admin/Bibliothecaire/User |
| Middleware protection | ✅/❌ | /2 | Routes sécurisées |
| CSRF & Sécurité | ✅/❌ | /2 | Protection forms |
| Gestion profil | ✅/❌ | /2 | Edit password, email |
| Tests unitaires | ✅/❌ | /2 | Feature tests |
| Extensions réalisées | ✅/❌ | /2 | Bonus |
| **TOTAL** | | **/16** | |

---

## 💡 Points d'Attention

### ❌ Erreurs Courantes
- Stocker les passwords en clair (utiliser `Hash::make()`)
- Oublier `@csrf` dans les formulaires
- Ne pas logger les tentatives échouées
- Rate limiting manquant sur login
- Email verification optionnel mais important
- Pas de timeout sur les sessions

### ✅ Bonnes Pratiques
- Toujours hasher les passwords
- Implémenter un timeout de session (30 min)
- Logger les actions sensibles (login, delete)
- Utiliser HTTPS en production
- Implémenter la vérification d'email
- Tester l'authentification avec des tests Feature
- Ne jamais exposer les tokens en logs
- Invalider la session sur logout (tous les navigateurs)

---

## 🔗 Ressources

- [Authentication](https://laravel.com/docs/11.x/authentication)
- [Authorization](https://laravel.com/docs/11.x/authorization)
- [Middleware](https://laravel.com/docs/11.x/middleware)
- [Hashing](https://laravel.com/docs/11.x/hashing)
- [Password Reset](https://laravel.com/docs/11.x/password-reset)
- [Security CSRF](https://laravel.com/docs/11.x/csrf)

---

**Fin du programme pédagogique** → 🎉 Prêt pour la production !

