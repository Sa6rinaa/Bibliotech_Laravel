## 🛣️ **TP1.5 - Routes de Base (10 minutes)**

### **🎪 Objectif**
Créer vos premières routes Laravel personnelles pour comprendre le système de routage et tester différents types de routes.

### **📋 Prérequis**
- ✅ TP0 terminé (familiarité avec l'interface)
- ✅ VS Code ouvert dans Codespace
- ✅ Fichier `routes/web.php` accessible

---

### **🏗️ Étape 1 : Route Simple `/about` (3 minutes)**

#### **1.1 Ajouter la Route**
1. **Ouvrir** `routes/web.php` dans VS Code
2. **Localiser** les routes existantes (vers la fin du fichier)
3. **Ajouter** votre première route personnelle :

```php
// À la fin du fichier routes/web.php, avant la ligne finale
// Vos premières routes personnelles - TP1.5

// Route 1 : Page À Propos simple
Route::get('/about', function () {
    return '<h1>À Propos de BiblioTech</h1>
            <p>BiblioTech est une application de gestion de bibliothèque moderne créée avec Laravel.</p>
            <p><strong>Version :</strong> 1.0.0</p>
            <p><strong>Créé par :</strong> [Votre Nom]</p>
            <a href="/">← Retour à l\'accueil</a>';
});
```

#### **1.2 Tester la Route**
4. **Sauvegarder** le fichier (Ctrl+S)
5. **Ouvrir** http://localhost:8000/about dans le navigateur
6. **Vérifier** que la page s'affiche correctement

**✅ Résultat attendu :** Page simple avec titre, informations et lien de retour

---

### **🎯 Étape 2 : Route avec Paramètre `/test/{name}` (4 minutes)**

#### **2.1 Ajouter la Route Paramètrée**
7. **Ajouter** sous la route précédente :

```php
// Route 2 : Test avec paramètre nom
Route::get('/test/{name}', function ($name) {
    $message = "Bonjour " . ucfirst($name) . " ! 👋";
    $time = date('H:i:s');
    
    return '<div style="font-family: Arial; padding: 20px; text-align: center;">
                <h1 style="color: #3498db;">' . $message . '</h1>
                <p>Il est actuellement <strong>' . $time . '</strong></p>
                <p>Vous avez testé avec succès une route Laravel avec paramètre !</p>
                <hr>
                <p><em>Route testée :</em> <code>/test/' . $name . '</code></p>
                <a href="/" style="color: #2ecc71;">← Retour à l\'accueil</a>
            </div>';
});
```

#### **2.2 Tester Plusieurs Variations**
8. **Tester** plusieurs noms dans le navigateur :
   - http://localhost:8000/test/pierre
   - http://localhost:8000/test/marie
   - http://localhost:8000/test/alexandre

9. **Observer** comment le paramètre change la réponse

---

### **🔥 Étape 3 : Route Optionnelle `/hello/{name?}` (3 minutes)**

#### **3.1 Route avec Paramètre Optionnel**
10. **Ajouter** une troisième route plus avancée :

```php
// Route 3 : Paramètre optionnel avec valeur par défaut
Route::get('/hello/{name?}', function ($name = 'Visiteur') {
    $greetings = [
        'Bonjour', 'Salut', 'Hey', 'Coucou', 'Hello'
    ];
    $randomGreeting = $greetings[array_rand($greetings)];
    
    $isDefault = ($name === 'Visiteur');
    
    $html = '<div style="font-family: Arial; padding: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center; border-radius: 10px; margin: 20px;">
                <h1>' . $randomGreeting . ' ' . $name . ' ! 🎉</h1>';
    
    if ($isDefault) {
        $html .= '<p>Vous n\'avez pas précisé de nom, donc je vous appelle "Visiteur" par défaut.</p>
                  <p><strong>Essayez :</strong> <a href="/hello/votrenom" style="color: #FFD700;">/hello/votrenom</a></p>';
    } else {
        $html .= '<p>Ravi de vous rencontrer, ' . $name . ' !</p>
                  <p>Cette route fonctionne avec ou sans paramètre.</p>';
    }
    
    $html .= '<hr style="border-color: rgba(255,255,255,0.3);">
              <p><em>Route utilisée :</em> <code>/hello/' . ($isDefault ? '' : $name) . '</code></p>
              <a href="/" style="color: #FFD700;">← Retour à l\'accueil</a>
           </div>';
    
    return $html;
});
```

#### **3.2 Tester les Cas**
11. **Tester** les deux possibilités :
    - http://localhost:8000/hello (sans paramètre)
    - http://localhost:8000/hello/julie (avec paramètre)

---

### **🧪 Bonus : Liste de Vos Routes**

12. **Ajouter** une route pour lister vos créations :

```php
// Route Bonus : Liste de toutes vos routes de test
Route::get('/mes-routes', function () {
    return '<div style="font-family: Arial; padding: 20px;">
                <h1>🛣️ Mes Routes de Test</h1>
                <h3>Routes créées dans le TP1.5 :</h3>
                <ul style="list-style-type: none; padding: 0;">
                    <li style="margin: 10px 0; padding: 10px; background: #ecf0f1; border-radius: 5px;">
                        <strong><a href="/about">/about</a></strong> → Page à propos simple
                    </li>
                    <li style="margin: 10px 0; padding: 10px; background: #ecf0f1; border-radius: 5px;">
                        <strong><a href="/test/monnom">/test/{name}</a></strong> → Test avec paramètre obligatoire
                    </li>
                    <li style="margin: 10px 0; padding: 10px; background: #ecf0f1; border-radius: 5px;">
                        <strong><a href="/hello">/hello/{name?}</a></strong> → Salutation avec paramètre optionnel
                    </li>
                    <li style="margin: 10px 0; padding: 10px; background: #ecf0f1; border-radius: 5px;">
                        <strong><a href="/mes-routes">/mes-routes</a></strong> → Cette page !
                    </li>
                </ul>
                <p><a href="/">← Retour à l\'accueil BiblioTech</a></p>
            </div>';
});
```

---

### **✅ Validation TP1.5**

**Checklist de réussite :**
- [ ] Route `/about` fonctionne et affiche les informations
- [ ] Route `/test/{name}` accepte différents noms et les affiche
- [ ] Route `/hello/{name?}` fonctionne avec ET sans paramètre
- [ ] Route bonus `/mes-routes` liste toutes mes créations
- [ ] Je comprends la différence entre paramètre obligatoire `{name}` et optionnel `{name?}`

**🔍 Questions de Compréhension :**
1. ❓ Que se passe si j'essaie d'accéder à `/test` sans paramètre ?
2. ❓ Comment Laravel fait la différence entre `/test/pierre` et `/hello/pierre` ?
3. ❓ Où sont définies ces routes dans le code ?

**Réponses :**
1. **Erreur 404** car le paramètre `{name}` est obligatoire
2. **Ordre et structure** : Laravel match la première route qui correspond au pattern
3. **Fichier `routes/web.php`** : toutes les routes web y sont définies

---

### **🎯 Code Final Complet**

À la fin de ces TPs, votre fichier `routes/web.php` devrait contenir :

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// Routes BiblioTech existantes
Route::get('/', [BookController::class, 'home'])->name('home');
Route::get('/catalogue', [BookController::class, 'index'])->name('books.index');
Route::get('/livre/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/recherche', [BookController::class, 'search'])->name('books.search');

// === VOS ROUTES DE TEST - TP1.5 ===

// Route 1 : Page À Propos simple
Route::get('/about', function () {
    return '<h1>À Propos de BiblioTech</h1>
            <p>BiblioTech est une application de gestion de bibliothèque moderne créée avec Laravel.</p>
            <p><strong>Version :</strong> 1.0.0</p>
            <p><strong>Créé par :</strong> [Votre Nom]</p>
            <a href="/">← Retour à l\'accueil</a>';
});

// Route 2 : Test avec paramètre nom
Route::get('/test/{name}', function ($name) {
    $message = "Bonjour " . ucfirst($name) . " ! 👋";
    $time = date('H:i:s');
    
    return '<div style="font-family: Arial; padding: 20px; text-align: center;">
                <h1 style="color: #3498db;">' . $message . '</h1>
                <p>Il est actuellement <strong>' . $time . '</strong></p>
                <p>Vous avez testé avec succès une route Laravel avec paramètre !</p>
                <hr>
                <p><em>Route testée :</em> <code>/test/' . $name . '</code></p>
                <a href="/" style="color: #2ecc71;">← Retour à l\'accueil</a>
            </div>';
});

// Route 3 : Paramètre optionnel avec valeur par défaut
Route::get('/hello/{name?}', function ($name = 'Visiteur') {
    $greetings = [
        'Bonjour', 'Salut', 'Hey', 'Coucou', 'Hello'
    ];
    $randomGreeting = $greetings[array_rand($greetings)];
    
    $isDefault = ($name === 'Visiteur');
    
    $html = '<div style="font-family: Arial; padding: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center; border-radius: 10px; margin: 20px;">
                <h1>' . $randomGreeting . ' ' . $name . ' ! 🎉</h1>';
    
    if ($isDefault) {
        $html .= '<p>Vous n\'avez pas précisé de nom, donc je vous appelle "Visiteur" par défaut.</p>
                  <p><strong>Essayez :</strong> <a href="/hello/votrenom" style="color: #FFD700;">/hello/votrenom</a></p>';
    } else {
        $html .= '<p>Ravi de vous rencontrer, ' . $name . ' !</p>
                  <p>Cette route fonctionne avec ou sans paramètre.</p>';
    }
    
    $html .= '<hr style="border-color: rgba(255,255,255,0.3);">
              <p><em>Route utilisée :</em> <code>/hello/' . ($isDefault ? '' : $name) . '</code></p>
              <a href="/" style="color: #FFD700;">← Retour à l\'accueil</a>
           </div>';
    
    return $html;
});

// Route Bonus : Liste de toutes vos routes de test
Route::get('/mes-routes', function () {
    return '<div style="font-family: Arial; padding: 20px;">
                <h1>🛣️ Mes Routes de Test</h1>
                <h3>Routes créées dans le TP1.5 :</h3>
                <ul style="list-style-type: none; padding: 0;">
                    <li style="margin: 10px 0; padding: 10px; background: #ecf0f1; border-radius: 5px;">
                        <strong><a href="/about">/about</a></strong> → Page à propos simple
                    </li>
                    <li style="margin: 10px 0; padding: 10px; background: #ecf0f1; border-radius: 5px;">
                        <strong><a href="/test/monnom">/test/{name}</a></strong> → Test avec paramètre obligatoire
                    </li>
                    <li style="margin: 10px 0; padding: 10px; background: #ecf0f1; border-radius: 5px;">
                        <strong><a href="/hello">/hello/{name?}</a></strong> → Salutation avec paramètre optionnel
                    </li>
                    <li style="margin: 10px 0; padding: 10px; background: #ecf0f1; border-radius: 5px;">
                        <strong><a href="/mes-routes">/mes-routes</a></strong> → Cette page !
                    </li>
                </ul>
                <p><a href="/">← Retour à l\'accueil BiblioTech</a></p>
            </div>';
});
```

## 🎉 **Bravo !**

Vous avez terminé les **TPs préparatoires** ! Vous comprenez maintenant :

✅ **Comment BiblioTech est construite** (TP0)  
✅ **Comment créer des routes Laravel** (TP1.5)  
✅ **La différence entre routes simples, paramétrées et optionnelles**  
✅ **Le lien entre URL et code PHP**

**🚀 Prochaine étape :** Passer aux TPs principaux de la Séance 1 pour créer des contrôleurs et des vues Blade complètes !