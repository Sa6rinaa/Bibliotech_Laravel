---
marp: true
theme: default
paginate: true
backgroundColor: #fff
backgroundImage: url('https://marp.app/assets/hero-background.svg')
header: 'POO - Programmation Orientée Objet'
footer: 'BTS SIO SLAM - Projet BiblioTech - 2025'
---

<!-- _class: lead -->
# 🎯 Programmation Orientée Objet (POO)
## Les Concepts Fondamentaux

**Projet BiblioTech**
BTS SIO SLAM - Septembre-Octobre 2025

---

## 📋 Plan de la Présentation

1. **Qu'est-ce que la POO ?**
2. **L'Objet : Définition**
3. **Les Concepts Clés**
4. **Les 4 Piliers de la POO**
5. **Exemples Concrets (BiblioTech)**
6. **Exercices Pratiques**

---

<!-- _class: lead -->
# 1️⃣ Qu'est-ce que la POO ?

---

## 🤔 La POO en Une Phrase

> **La Programmation Orientée Objet est une façon de coder qui organise le programme comme le monde réel : avec des objets qui ont des caractéristiques et des actions.**

---

## 🌍 Analogie du Monde Réel

**Dans le monde réel :**
- Un **livre** a un titre, un auteur, un ISBN
- Un **livre** peut être emprunté, retourné, consulté

**En programmation POO :**
- Un **objet Livre** a des **attributs** (titre, auteur, ISBN)
- Un **objet Livre** a des **méthodes** (emprunter, retourner, consulter)

💡 **La POO modélise le monde réel en code !**

---

## 📊 Programmation Procédurale vs POO

| Programmation Procédurale | Programmation Orientée Objet |
|---------------------------|-------------------------------|
| Suite d'instructions | Objets qui interagissent |
| Fonctions indépendantes | Méthodes liées aux objets |
| Données séparées | Données + comportements |
| Difficile à maintenir | Facile à maintenir |
| Exemple : C | Exemple : PHP, Java, Python |

---

<!-- _class: lead -->
# 2️⃣ L'Objet : Définition

---

## 🎁 Qu'est-ce qu'un Objet ?

> **Un objet est une entité qui possède :**
> - **Des caractéristiques** (attributs / propriétés)
> - **Des comportements** (méthodes / actions)

### Exemple : Un livre 📚

**Caractéristiques :**
- Titre : "Harry Potter" - Auteur : "J.K. Rowling" - ISBN : "978-2-07-061667-0"

**Comportements :**
- Être emprunté - Être retourné - Être consulté

---

## 🏗️ Classe vs Objet

### 📐 **Classe** : Le Plan / Le Moule
> La classe est le **modèle** qui définit comment sera un objet

```php
class Livre {     // Définition du modèle
}
```

### 🎁 **Objet** : L'Instance Concrète
> L'objet est une **réalisation concrète** créée à partir de la classe

```php
$livre1 = new Livre();  // Un objet
$livre2 = new Livre();  // Un autre objet
```

💡 **Une classe = un moule à gâteaux**
💡 **Un objet = un gâteau fait avec ce moule**

---

## 🎯 Exemple Visuel

```
┌─────────────────────────┐
│   Classe : Livre        │  ← Le PLAN / MODÈLE
│   - titre               │
│   - auteur              │
│   - isbn                │
│   + emprunter()         │
│   + retourner()         │
└─────────────────────────┘
            │
            │ new Livre()
            ↓
┌──────────────────────────────────────────────────┐
│  $livre1                $livre2                  │
│  titre: "Harry Potter"  titre: "Le Seigneur..."  │
│  auteur: "Rowling"      auteur: "Tolkien"        │
│  isbn: "978-2..."       isbn: "978-3..."         │
└──────────────────────────────────────────────────┘
   ↑ Les OBJETS (instances concrètes)
```

---

<!-- _class: lead -->
# 3️⃣ Les Concepts Clés

---

## 📦 1. Attribut (Propriété)

> **Un attribut est une caractéristique d'un objet**
> C'est une **variable** qui appartient à l'objet

### Exemple dans BiblioTech :

```php
class Livre {
    public $titre;        // Attribut
    public $auteur;       // Attribut
    public $isbn;         // Attribut
    public $disponible;   // Attribut
}
```

💡 **Un attribut décrit CE QU'EST l'objet**

---

## ⚙️ 2. Méthode (Action)

> **Une méthode est une action que peut faire un objet**
> C'est une **fonction** qui appartient à l'objet

### Exemple dans BiblioTech :

```php
class Livre {
    public function emprunter() {     // Méthode
        $this->disponible = false;
    }
    
    public function retourner() {     // Méthode
        $this->disponible = true;
    }
}
```

💡 **Une méthode décrit CE QUE FAIT l'objet**

---

## 🎯 Attributs vs Méthodes

| Attribut | Méthode |
|----------|---------|
| **Caractéristique** | **Action** |
| Ce qu'**est** l'objet | Ce que **fait** l'objet |
| Variable | Fonction |
| Substantif (nom) | Verbe (action) |
| `$titre`, `$auteur` | `emprunter()`, `retourner()` |

### Analogie 🚗
- **Attributs** : couleur, marque, vitesse actuelle
- **Méthodes** : démarrer(), accélérer(), freiner()

---

## 🏗️ 3. Constructeur

> **Le constructeur est une méthode spéciale qui initialise l'objet à sa création**
> Elle s'exécute automatiquement avec `new`

### Exemple dans BiblioTech :

```php
class Livre {
    public $titre;
    public $auteur;
    
    public function __construct($titre, $auteur) {
        $this->titre = $titre;
        $this->auteur = $auteur;
    }
}
$livre = new Livre("Harry Potter", "J.K. Rowling");
```

💡 **Le constructeur prépare l'objet dès sa naissance**

---

## 🔍 4. $this

> **$this fait référence à l'objet lui-même**
> C'est comme dire "moi" en parlant de soi

### Exemple :

```php
class Livre {
    public $titre;
    
    public function afficherTitre() {
        echo $this->titre;  // "mon" titre
    }
}
$livre1 = new Livre();
$livre1->titre = "Harry Potter";
$livre1->afficherTitre();  // Affiche : Harry Potter
```

💡 **$this = "moi, cet objet"**

---

<!-- _class: lead -->
# 4️⃣ Les 4 Piliers de la POO

---

## 🏛️ Les 4 Piliers

1. **Encapsulation** 🔒
2. **Héritage** 👨‍👦
3. **Polymorphisme** 🎭
4. **Abstraction** 🎨

**Ces 4 concepts sont la base de la POO !**

---

## 🔒 1. Encapsulation

> **Cacher les détails internes et protéger les données**
> Accès contrôlé via des méthodes publiques

### Visibilité (Modificateurs d'accès) :

```php
class Livre {
    public $titre;        // Accessible partout ✅
    private $prix;        // Accessible uniquement dans la classe 🔒
    protected $stock;     // Accessible dans la classe et ses enfants 👨‍👦
}
```

💡 **public** = tout le monde peut voir
💡 **private** = seulement moi (la classe)
💡 **protected** = moi et mes enfants

---

## 🔒 Encapsulation : Exemple

### ❌ Sans Encapsulation (Mauvais)
```php
class CompteBancaire {
    public $solde;  // Accessible partout !
}

$compte = new CompteBancaire();
$compte->solde = 1000000;  // N'importe qui peut modifier ! 😱
```
### ✅ Avec Encapsulation (Bon)
```php
class CompteBancaire {
    private $solde;  // Protégé 🔒
    
    public function deposer($montant) {
        if ($montant > 0) {
            $this->solde += $montant;
        }
    }
}
```

---

## 👨‍👦 2. Héritage

> **Une classe peut hériter des attributs et méthodes d'une autre classe**
> Évite la répétition de code

### Exemple BiblioTech :

```php
class Document {  // Classe PARENT
    public $titre;
    public $auteur;
}
```

---
```php
class Livre extends Document {  // Classe ENFANT
    public $isbn;  // Ajoute un nouvel attribut
}

class Magazine extends Document {  // Autre ENFANT
    public $numero;
}
```

💡 **Livre hérite de Document** = Livre a tout ce que Document a + plus

---

## 👨‍👦 Héritage : Schéma

```
        ┌───────────────────┐
        │    Document       │  ← PARENT
        │  - titre          │
        │  - auteur         │
        │  + afficher()     │
        └───────────────────┘
                 │
         ┌───────┴───────┐
         ↓               ↓
    ┌─────────┐    ┌──────────┐
    │  Livre  │    │ Magazine │  ← ENFANTS
    │  - isbn │    │ - numero │
    └─────────┘    └──────────┘
```

**Livre et Magazine** ont automatiquement `titre`, `auteur` et `afficher()`

---

## 🎭 3. Polymorphisme

> **Plusieurs formes pour une même action**
> Une méthode peut avoir un comportement différent selon l'objet

### Exemple :

```php
class Document {
    public function afficher() {
        echo "Document générique";
    }
}

---

class Livre extends Document {
    public function afficher() {  // Redéfinition
        echo "Livre : " . $this->titre;
    }
}

class Magazine extends Document {
    public function afficher() {  // Redéfinition
        echo "Magazine n°" . $this->numero;
    }
}
```

---

## 🎭 Polymorphisme : Utilisation

```php
$doc1 = new Livre();
$doc1->afficher();  // Affiche : Livre : ...

$doc2 = new Magazine();
$doc2->afficher();  // Affiche : Magazine n°...

$documents = [$doc1, $doc2];

foreach ($documents as $doc) {
    $doc->afficher();  // Chacun s'affiche différemment !
}
```

💡 **Même méthode `afficher()`, comportements différents**

---

## 🎨 4. Abstraction

> **Montrer seulement ce qui est essentiel, cacher la complexité**
> Définir "quoi faire" sans dire "comment faire"

### Classe Abstraite :

```php
abstract class Document {  // Ne peut pas être instanciée
    abstract public function calculerTarif();  // Doit être définie
}
class Livre extends Document {
    public function calculerTarif() {
        return 15.99;  // Implémentation concrète
    }
}
// $doc = new Document();  // ❌ ERREUR !
$livre = new Livre();      // ✅ OK
```

💡 **Une classe abstraite est un contrat**

---

<!-- _class: lead -->
# 5️⃣ POO Traditionnelle vs Laravel
## ⚠️ Différences Importantes

---

## 🔄 POO Traditionnelle vs Laravel

> **ATTENTION : Laravel utilise la POO différemment !**

### 📌 POO Traditionnelle (Exemples Pédagogiques)
```php
class Livre {
    private $titre;
    public function __construct($titre) {
        $this->titre = $titre;
    }
    public function emprunter() { /* logique */ }
}
```
---

### 📌 Laravel / BiblioTech (Réalité du Projet)
```php
class Livre extends Model {
    protected $table = 'livres';
    protected $fillable = ['titre', 'auteur'];
    // Pas de $titre défini !
    // Pas de méthodes métier ici !
}
```

---

## 🎯 Différence 1 : Les Attributs

### ❌ POO Traditionnelle
```php
class Livre {
    private $titre;      // Attribut déclaré
    private $auteur;     // Attribut déclaré
    private $isbn;       // Attribut déclaré
}
```

### ✅ Laravel (BiblioTech Réel)
```php
class Livre extends Model {
    // AUCUN attribut déclaré !
    protected $fillable = ['titre', 'auteur', 'isbn'];
    // Laravel gère les attributs automatiquement
}
// Utilisation :
$livre = Livre::find(1);
echo $livre->titre;  // Fonctionne magiquement ! ✨
```

💡 **Laravel utilise des "magic methods" PHP (`__get`, `__set`)**

---

## 🎯 Différence 2 : Les Méthodes Métier

### ❌ POO Traditionnelle
```php
class Livre {
    public function emprunter() {
        $this->disponible = false;
    }    
    public function retourner() {
        $this->disponible = true;
    }
}
```
---
### ✅ Laravel (BiblioTech Réel)
```php
// Dans le MODÈLE : uniquement relations
class Livre extends Model {
    public function emprunts() {
        return $this->hasMany(Emprunt::class);
    }
}

// Dans le CONTRÔLEUR : logique métier
class LivreControleur extends Controller {
    public function emprunter($id) {
        $livre = Livre::find($id);
        $livre->disponible = false;
        $livre->save();
    }
}
```

💡 **Séparation : Modèle = Données, Contrôleur = Logique**

---

## 🎯 Différence 3 : Création d'Objets

### ❌ POO Traditionnelle
```php
$livre = new Livre("Harry Potter", "J.K. Rowling");
```
---

### ✅ Laravel (BiblioTech Réel)
```php
// Méthode 1 : Avec new (rarement utilisé)
$livre = new Livre();
$livre->titre = "Harry Potter";
$livre->save();  // Sauvegarde en BDD

// Méthode 2 : Avec create (le plus courant)
$livre = Livre::create([
    'titre' => 'Harry Potter',
    'auteur' => 'J.K. Rowling'
]);

// Méthode 3 : Récupération depuis BDD
$livre = Livre::find(1);  // Charge depuis la BDD
```

💡 **Laravel = ORM Active Record (objet = ligne de BDD)**

---

## 🎯 Différence 4 : Les Relations

### ❌ POO Traditionnelle
```php
class Utilisateur {
    private $emprunts = [];  // Tableau d'objets
    
    public function ajouterEmprunt($emprunt) {
        $this->emprunts[] = $emprunt;
    }
}
```
---
### ✅ Laravel (BiblioTech Réel)
```php
// Dans le MODÈLE Utilisateur
class Utilisateur extends Model {
    public function emprunts() {
        return $this->hasMany(Emprunt::class, 'utilisateur_id');
    }
}

// Utilisation
$utilisateur = Utilisateur::find(1);
$emprunts = $utilisateur->emprunts;  // Requête BDD automatique !
```

💡 **Les relations Laravel interrogent la BDD à la demande**

---

## 🎯 Différence 5 : Requêtes et Méthodes Statiques

### ❌ POO Traditionnelle
```php
// Pas de méthodes statiques dans POO pure
$livre = new Livre();
```
---

### ✅ Laravel (BiblioTech Réel)
```php
// Méthodes statiques du Query Builder
$livres = Livre::all();                    // Tous les livres
$livre = Livre::find(1);                   // Livre par ID
$livres = Livre::where('disponible', true)->get();  // Filtre
$livre = Livre::findOrFail(1);            // Ou erreur 404

// Chaînage de méthodes
$livres = Livre::where('auteur', 'Tolkien')
               ->orderBy('titre')
               ->limit(10)
               ->get();
```

💡 **Eloquent = Query Builder orienté objet**

---

## 📊 Tableau Comparatif

| Aspect | POO Traditionnelle | Laravel (BiblioTech) |
|--------|-------------------|----------------------|
| **Attributs** | Déclarés explicitement | Gérés automatiquement |
| **Constructeur** | Obligatoire | Rarement utilisé |
| **Logique métier** | Dans le modèle | Dans le contrôleur |
| **Relations** | Tableaux d'objets | Méthodes Eloquent |
| **Persistance** | Manuel (fichier/BDD) | Automatique (`save()`) |
| **Requêtes** | SQL manuel | Query Builder |
| **Pattern** | Simple POO | Active Record + MVC |

---

## 🏗️ Architecture Laravel (BiblioTech)

```
┌─────────────────────────────────────────────────┐
│                  Route                          │
│            routes/web.php                       │
│     Route::get('/livres', [LivreControleur...]) │
└─────────────────┬───────────────────────────────┘
                  │
                  ↓
┌─────────────────────────────────────────────────┐
│              CONTRÔLEUR                         │
│      app/Http/Controleurs/LivreControleur.php   │
│                                                 │
│  - Reçoit la requête                           │
│  - Appelle le modèle                           │
│  - Retourne la vue                             │
└─────────────────┬───────────────────────────────┘
                  │
        ┌─────────┴─────────┐
        ↓                   ↓
┌───────────────┐   ┌──────────────────┐
│    MODÈLE     │   │      VUE         │
│ app/Modeles/  │   │ resources/views/ │
│   Livre.php   │   │   livres/        │
│               │   │   index.blade    │
│ - Relations   │   │                  │
│ - Accesseurs  │   │ - Affichage      │
│ - $fillable   │   │ - HTML           │
└───────┬───────┘   └──────────────────┘
        │
        ↓
┌──────────────────┐
│   BASE DONNÉES   │
│  database.sqlite │
│                  │
│  Table: livres   │
└──────────────────┘
```

---

## 📝 Fichier Réel : Livre.php (BiblioTech)

```php
<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    // ✅ Nom de la table
    protected $table = 'livres';
    
    // ✅ Champs modifiables (masse assignment)
    protected $fillable = [
        'titre',
        'auteur',
        'isbn',
        'disponible',
        'categorie'
    ];
    
    // ✅ Casts : types des attributs
    protected $casts = [
        'disponible' => 'boolean',
        'date_creation' => 'datetime'
    ];
    
    // ✅ RELATIONS (pas de logique métier !)
    public function emprunts()
    {
        return $this->hasMany(Emprunt::class, 'livre_id');
    }
}
```

**❌ PAS de :** `private $titre`, `public function emprunter()`

---

## 📝 Fichier Réel : LivreControleur.php

```php
<?php

namespace App\Http\Controleurs;

use App\Modeles\Livre;
use Illuminate\Http\Request;

class LivreControleur extends Controller
{
    // ✅ LOGIQUE MÉTIER ICI (pas dans le modèle)
    
    public function index()
    {
        $livres = Livre::all();  // Méthode statique
        return view('livres.index', compact('livres'));
    }
    
    public function stocker(Request $requete)
    {
        // Validation
        $donnees_validees = $requete->validate([
            'titre' => 'required|max:255',
            'auteur' => 'required|max:255'
        ]);
        
        // Création (pas de new + constructeur)
        $livre = Livre::create($donnees_validees);
        
        // Redirection
        return redirect()->route('livres.index')
                         ->with('succes', 'Livre créé !');
    }
    
    public function emprunter($id)
    {
        $livre = Livre::findOrFail($id);
        $livre->disponible = false;  // Accès magique !
        $livre->save();  // Sauvegarde en BDD
        
        return redirect()->back();
    }
}
```

---

## 🎓 Ce qu'il faut Retenir

### ✅ **POO Traditionnelle (Théorie)**
- Attributs déclarés : `private $titre;`
- Constructeur avec paramètres
- Méthodes métier dans la classe : `emprunter()`
- Gestion manuelle de la persistance
- **But : Comprendre les concepts POO**
- 
---

### ✅ **Laravel / BiblioTech (Pratique)**
- Pas d'attributs déclarés (gérés par Eloquent)
- Rarement de constructeur personnalisé
- Logique métier dans les contrôleurs
- Persistance automatique avec `save()`
- Relations via méthodes spéciales
- **But : Productivité et convention**

💡 **Les concepts POO restent valables, mais l'implémentation diffère !**

---

## 🔑 Pourquoi cette Différence ?

### **Laravel utilise le pattern Active Record**
> Chaque objet Modèle = 1 ligne dans la BDD

**Avantages :**
✅ Moins de code à écrire
✅ Requêtes BDD automatiques
✅ Relations puissantes
✅ Conventions standardisées

**Laravel ajoute :**
- **Magic methods** pour accès aux attributs
- **Query Builder** pour requêtes fluides
- **Eloquent ORM** pour mapping objet-relationnel

---
| POO Traditionnelle | Laravel (BiblioTech) |
|-------------------|----------------------|
| **Déclaration** | |
| `private $titre;` | `protected $fillable = ['titre'];` |
| `private $auteur;` | *(géré automatiquement)* |
| | |
| **Constructeur** | |
| `__construct($titre, $auteur)` | *(rarement utilisé)* |
| `$this->titre = $titre;` | *(Magic methods)* |
| | |


---
## 📚 Comparaison Côte à Côte

| POO Traditionnelle | Laravel (BiblioTech) |
|-------------------|----------------------|
| **Création** | |
| `$livre = new Livre(...);` | `$livre = Livre::create([...]);` |
| | `$livre = Livre::find(1);` |
| | |
| **Accès** | |
| `$livre->getTitre()` | `$livre->titre` *(magic)* |
| | |
| **Logique** | |
| `public function emprunter()` | → **Contrôleur** |
| *(dans la classe)* | *(pas dans le modèle)* |

---





## 📚 En Résumé

### **📖 Dans les Exemples Pédagogiques :**
```php
class Livre {
    private $titre;
    public function __construct($titre) { ... }
    public function emprunter() { ... }
}
```
→ **POO pure pour apprendre les concepts**

---

### **🚀 Dans BiblioTech (Projet Réel) :**
```php
class Livre extends Model {
    protected $fillable = ['titre', 'auteur'];
    public function emprunts() { return $this->hasMany(...); }
}
```
→ **Laravel Eloquent pour la productivité**

💡 **Les deux utilisent la POO, mais avec des approches différentes**

---

<!-- _class: lead -->
# 6️⃣ Exemples Concrets
## Projet BiblioTech (Réalité)

---

## 📚 Modèle Livre (Version Réelle)

**Fichier :** `app/Modeles/Livre.php`

```php
<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    // ✅ Nom de la table (convention Laravel)
    protected $table = 'livres';
    
    // ✅ Champs qui peuvent être remplis en masse
    protected $fillable = [
        'titre',
        'auteur',
        'isbn',
        'disponible',
        'categorie'
    ];
    
    // ✅ Conversion automatique des types
    protected $casts = [
        'disponible' => 'boolean',
        'date_creation' => 'datetime'
    ];
    
    // ✅ RELATION : Un livre a plusieurs emprunts
    public function emprunts()
    {
        return $this->hasMany(Emprunt::class, 'livre_id');
    }
    
    // ✅ ACCESSEUR : Titre en majuscules
    public function getTitreEnMajusculesAttribute()
    {
        return strtoupper($this->titre);
    }
}
```

**⚠️ Notez bien : PAS de `private $titre`, PAS de méthode `emprunter()` !**

---

## 🎯 Utilisation du Modèle Livre

**Fichier :** `app/Http/Controleurs/LivreControleur.php`

```php
// ✅ CRÉATION avec create() - méthode statique
$livre = Livre::create([
    'titre' => 'Harry Potter',
    'auteur' => 'J.K. Rowling',
    'isbn' => '978-2-07-061667-0',
    'disponible' => true
]);

// ✅ RÉCUPÉRATION depuis la BDD
$livre = Livre::find(1);                    // Par ID
$livres = Livre::all();                     // Tous
$livres = Livre::where('disponible', true)->get();  // Filtrés

// ✅ AFFICHAGE (accès magique aux attributs)
echo $livre->titre;              // Harry Potter
echo $livre->titre_en_majuscules; // HARRY POTTER (accesseur)

// ✅ MODIFICATION
$livre->disponible = false;
$livre->save();  // Sauvegarde en BDD

// ✅ SUPPRESSION
$livre->delete();
```

**💡 Tout est automatique grâce à Eloquent !**

---

## 👤 Modèle Utilisateur (Version Réelle)

**Fichier :** `app/Modeles/Utilisateur.php`

```php
<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateurs';
    
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe'
    ];
    
    protected $hidden = [
        'mot_de_passe'  // Caché dans JSON
    ];
    
    // ✅ RELATION : Un utilisateur a plusieurs emprunts
    public function emprunts()
    {
        return $this->hasMany(Emprunt::class, 'utilisateur_id');
    }
    
    // ✅ ACCESSEUR : Nom complet
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }
    
    // ✅ MÉTHODE HELPER : Nombre d'emprunts
    public function nombreEmprunts()
    {
        return $this->emprunts()->count();
    }
}
```

---

## 🤝 Interaction entre Objets (Version Réelle)

**Fichier :** `app/Http/Controleurs/EmpruntControleur.php`

```php
public function emprunter(Request $requete)
{
    // ✅ Récupération depuis BDD (pas de new)
    $utilisateur = Utilisateur::find($requete->utilisateur_id);
    $livre = Livre::find($requete->livre_id);
    
    // ✅ Vérification
    if (!$livre->disponible) {
        return back()->with('erreur', 'Livre non disponible');
    }
    
    // ✅ Création de l'emprunt
    $emprunt = Emprunt::create([
        'utilisateur_id' => $utilisateur->id,
        'livre_id' => $livre->id,
        'date_emprunt' => now(),
        'date_retour_prevue' => now()->addDays(14)
    ]);
    
    // ✅ Mise à jour du livre
    $livre->disponible = false;
    $livre->save();
    
    // ✅ Message de succès
    return redirect()->route('emprunts.index')
        ->with('succes', $utilisateur->nom_complet . 
               ' a emprunté ' . $livre->titre);
}
```

**💡 Les relations Eloquent gèrent automatiquement les liens !**

---

## 🔗 Utilisation des Relations

```php
// ✅ Récupérer un utilisateur avec ses emprunts
$utilisateur = Utilisateur::with('emprunts')->find(1);

// ✅ Afficher les emprunts
foreach ($utilisateur->emprunts as $emprunt) {
    echo $emprunt->livre->titre;  // Accès au livre via relation
}

// ✅ Compter les emprunts (sans charger tous les objets)
$nombre = $utilisateur->emprunts()->count();

// ✅ Récupérer uniquement les emprunts en cours
$emprunts_actifs = $utilisateur->emprunts()
    ->whereNull('date_retour_effective')
    ->get();

// ✅ Récupérer un livre avec tous ses emprunts
$livre = Livre::with('emprunts.utilisateur')->find(1);
foreach ($livre->emprunts as $emprunt) {
    echo $emprunt->utilisateur->nom_complet;
}
```

**💡 Eloquent charge automatiquement les données liées !**

---

## 🏗️ Héritage dans BiblioTech (Réalité)

**⚠️ Dans BiblioTech, tous les modèles héritent de `Model` (Eloquent)**

```php
// ✅ TOUS les modèles héritent de Model
use Illuminate\Database\Eloquent\Model;

class Livre extends Model { }
class Utilisateur extends Model { }
class Emprunt extends Model { }
```

**Ce que donne l'héritage de `Model` :**
- Méthodes : `save()`, `delete()`, `find()`, `create()`
- Relations : `hasMany()`, `belongsTo()`, `belongsToMany()`
- Query Builder : `where()`, `orderBy()`, `get()`
- Timestamps automatiques : `date_creation`, `date_modification`

---

## 🏗️ Héritage Personnalisé (Si Besoin)

**On peut créer notre propre classe de base :**

```php
// Classe de base personnalisée
abstract class Document extends Model
{
    protected $fillable = ['titre', 'auteur'];
    
    public function afficherInfos()
    {
        return $this->titre . " par " . $this->auteur;
    }
}

// Les enfants héritent
class Livre extends Document
{
    protected $table = 'livres';
    
    public function afficherInfos()
    {
        return parent::afficherInfos() . " (ISBN: " . $this->isbn . ")";
    }
}

class Magazine extends Document
{
    protected $table = 'magazines';
}
```

**💡 Mais dans BiblioTech, on hérite directement de `Model`**

---

<!-- _class: lead -->
# 7️⃣ Exercices Pratiques

**⚠️ IMPORTANT :** Ces exercices sont en **POO traditionnelle** pour comprendre les concepts

---

## 🎯 Exercice 1 : Créer une Classe (POO Pure)

**Créez une classe `Emprunt` avec :**

**Attributs privés :**
- `utilisateur` (objet Utilisateur)
- `livre` (objet Livre)
- `dateEmprunt` (date)
- `dateRetourPrevue` (date)
- `dateRetourEffective` (date, peut être null)

**Méthodes publiques :**
- `__construct($utilisateur, $livre)` : initialise l'emprunt
- `retourner()` : enregistre la date de retour effective
- `estEnRetard()` : vérifie si le retour est en retard
- `calculerJoursRetard()` : calcule le nombre de jours de retard

**💡 Cet exercice est pour comprendre les concepts POO de base**

---

## 🎯 Exercice 2 : Héritage (POO Pure)

**Créez une hiérarchie de classes :**

```
                Document
                    │
        ┌───────────┼───────────┐
        │           │           │
     Livre      Magazine    DVD
```

**Chaque classe doit avoir :**
- Ses propres attributs spécifiques
- Une méthode `afficherInfos()` redéfinie
- Une méthode `calculerTarif()` spécifique

**💡 Pour pratiquer l'héritage et le polymorphisme**

---

## 🎯 Exercice 3 : Relations (POO Pure)

**Créez les classes suivantes avec leurs relations :**

```php
class Bibliotheque {
    // - Contient plusieurs livres (tableau)
    // - Contient plusieurs utilisateurs (tableau)
    // - Gère les emprunts
}

class Livre {
    // - Peut être emprunté par un utilisateur
}

class Utilisateur {
    // - Peut emprunter plusieurs livres (tableau)
}
```

**Implémentez :**
- `Bibliotheque->ajouterLivre($livre)`
- `Bibliotheque->inscrireUtilisateur($utilisateur)`
- `Bibliotheque->emprunter($utilisateur, $livre)`

**💡 Pour comprendre les relations entre objets**

---

## 🎯 Exercice 4 : Encapsulation (POO Pure)

**Améliorez la classe CompteBancaire :**

```php
class CompteBancaire {
    private $solde;
    private $titulaire;
    
    // TODO: Constructeur
    
    // TODO: deposer($montant)
    // - Vérifier que montant > 0
    
    // TODO: retirer($montant)
    // - Vérifier que montant > 0
    // - Vérifier que solde suffisant
    
    // TODO: getSolde() - mais seulement lecture !
    
    // TODO: transferer($montant, $compteDestination)
}
```

**💡 Pour maîtriser l'encapsulation (public/private)**

---

## 🎯 Exercice 5 : Application Laravel (Pratique)

**Dans BiblioTech, créez une nouvelle fonctionnalité :**

**Créez un modèle `Auteur` :**
- Fichier : `app/Modeles/Auteur.php`
- Champs : nom, prenom, nationalite, biographie
- Relation : Un auteur a plusieurs livres

**Créez le contrôleur `AuteurControleur` :**
- Méthodes : index(), stocker(), modifier(), supprimer()

**Créez les routes :**
- `Route::resource('auteurs', AuteurControleur::class);`

**💡 Exercice réel avec Laravel / BiblioTech**

---

## 📝 Glossaire - Termes POO (1/2)

| Terme | Définition Simple |
|-------|-------------------|
| **Objet** | Entité avec caractéristiques + actions |
| **Classe** | Modèle / Plan pour créer des objets |
| **Instance** | Un objet créé à partir d'une classe |
| **Attribut** | Caractéristique d'un objet (variable) |
| **Méthode** | Action d'un objet (fonction) |
| **Constructeur** | Méthode qui initialise l'objet |
| **$this** | Référence à l'objet lui-même |

---

## 📝 Glossaire - Termes POO (2/2)

| Terme | Définition Simple |
|-------|-------------------|
| **Encapsulation** | Protéger les données (public/private) |
| **Héritage** | Classe qui récupère d'une autre classe |
| **Polymorphisme** | Même méthode, comportements différents |
| **Abstraction** | Simplifier en cachant la complexité |
| **public** | Accessible partout |
| **private** | Accessible uniquement dans la classe |
| **protected** | Accessible dans la classe + enfants |

---

## 🎓 Points Clés à Retenir

✅ **Un objet = Caractéristiques + Actions**
✅ **Classe = Modèle, Objet = Instance**
✅ **Attribut = Variable, Méthode = Fonction**
✅ **Encapsulation = Protection des données**
✅ **Héritage = Réutilisation du code**
✅ **Polymorphisme = Flexibilité**
✅ **Abstraction = Simplification**

💡 **La POO organise le code comme le monde réel !**

---

## 📚 Pour Aller Plus Loin

### **📖 Comprendre la Théorie POO**
- Concepts fondamentaux (cette présentation)
- Exercices pratiques POO pure
- Design Patterns classiques

### **🚀 Maîtriser Laravel (BiblioTech)**

**Fichiers à explorer :**
- `app/Modeles/Livre.php` : Modèle Eloquent (relations, $fillable)
- `app/Http/Controleurs/LivreControleur.php` : Logique métier
- `database/migrations/` : Structure BDD
- `routes/web.php` : Routes vers contrôleurs

**Documentation Laravel :**
- Eloquent ORM : https://laravel.com/docs/eloquent
- Relations : https://laravel.com/docs/eloquent-relationships
- Query Builder : https://laravel.com/docs/queries

💡 **Comprendre POO théorique + Laravel pratique = Succès !**

---

## 🎯 Bonnes Pratiques POO

1. **Un objet = Une responsabilité** (principe SOLID)
2. **Nommer clairement** : `Livre`, `emprunter()`, `$titre`
3. **Encapsuler** : Attributs privés, méthodes publiques
4. **DRY** : Don't Repeat Yourself (utiliser l'héritage)
5. **Commenter** : Expliquer le "pourquoi", pas le "quoi"
6. **Tester** : Chaque classe doit être testable

---

<!-- _class: lead -->
# 🎉 Conclusion

---

## 🚀 Résumé

### **2 Niveaux de Compréhension de la POO :**

#### **1️⃣ POO Théorique (Concepts Fondamentaux)**
- Comprendre : Objet, Classe, Attribut, Méthode
- Les 4 piliers : Encapsulation, Héritage, Polymorphisme, Abstraction
- **But : Apprendre les concepts**
- Exemples : `private $titre`, `new Livre()`, `emprunter()`
  
---

#### **2️⃣ POO Laravel (Application Pratique)**
- Eloquent ORM = Active Record Pattern
- Modèles = accès aux données + relations
- Contrôleurs = logique métier
- **But : Productivité**
- Exemples : `Livre::find()`, `$livre->titre`, `$fillable`

💡 **Les concepts POO restent, mais l'implémentation change !**

---


## 🤔 Pourquoi Apprendre les Deux ?

### **1️⃣ POO Traditionnelle D'ABORD (Théorie)**

**Pourquoi ?**
- Comprendre les **fondamentaux** (objet, classe, méthode)
- Maîtriser les **concepts** (encapsulation, héritage)
- Applicable à **tous les langages** (Java, Python, C#)
- Base pour comprendre Laravel

**Exemple :** Savoir ce qu'est un attribut privé pour comprendre `$fillable`

### **2️⃣ Laravel ENSUITE (Pratique)**

**Pourquoi ?**
- Utiliser les **outils professionnels**
- Être **productif** rapidement
- Suivre les **conventions** du métier
- Travailler en **équipe**

**Exemple :** Utiliser Eloquent au lieu de tout coder à la main

💡 **Théorie → Compréhension → Pratique → Productivité**

---

## 🎯 Ce qu'il faut Retenir Absolument

### ✅ **Concepts POO (Toujours Valables)**
1. Organiser le code en objets
2. Encapsulation = protéger les données
3. Héritage = réutiliser le code
4. Polymorphisme = flexibilité

### ⚠️ **Différences Laravel (Important !)**
1. Pas d'attributs déclarés dans les modèles
2. Logique métier dans les contrôleurs (pas les modèles)
3. Relations via méthodes Eloquent
4. Méthodes statiques pour requêtes (`Livre::all()`)

### 💡 **Pour Réussir**
- Comprendre les concepts POO (théorie)
- Adapter à Laravel (pratique)
- Séparer Modèle / Contrôleur / Vue

---


<!-- _class: lead -->
# ❓ Questions ?

**N'hésitez pas à poser vos questions !**


---

<!-- _class: lead -->
# Merci ! 🙏

**Bonne pratique de la POO !**

