# 🔍 TP — SonarCloud + GitHub Actions

**Analyse de qualité de code automatisée pour BiblioTech**

Dernière mise à jour : Février 2026

---

## 🎯 Objectifs du TP

À l'issue de ce TP, vous serez capable de :

- ✅ **Comprendre** le rôle de l'analyse de qualité de code dans un projet professionnel
- ✅ **Configurer SonarCloud** sur un projet GitHub Laravel
- ✅ **Intégrer SonarCloud** dans un pipeline GitHub Actions
- ✅ **Interpréter** les métriques de qualité (bugs, vulnérabilités, code smells, dette technique)
- ✅ **Corriger** les problèmes identifiés par SonarCloud
- ✅ **Documenter** la démarche qualité dans votre portfolio

---

## 📋 Prérequis

- ✅ Repository GitHub BiblioTech avec du code Laravel fonctionnel
- ✅ Pipeline GitHub Actions existant (cf. [03-TP-TESTS-CICD.md](03-TP-TESTS-CICD.md))
- ✅ Tests PHPUnit qui passent (`php artisan test`)
- ✅ Compte GitHub actif

**Durée estimée : 45 minutes**

---

## 📚 Partie 1 — Comprendre SonarCloud (10 min)

### Qu'est-ce que SonarCloud ?

SonarCloud est un service d'**analyse statique de code** en mode SaaS (Software as a Service). Il examine votre code source sans l'exécuter pour détecter des problèmes de qualité, de sécurité et de maintenabilité.

### Différence avec les outils déjà utilisés

Vous utilisez déjà plusieurs outils de qualité dans votre pipeline CI/CD :

| Outil | Ce qu'il vérifie | Exemple |
|-------|------------------|---------|
| **PHPStan** | Erreurs de typage et logique PHP | Appel de méthode sur `null` |
| **Laravel Pint** | Style et formatage du code | Indentation, espaces, PSR-12 |
| **Composer Audit** | Vulnérabilités des dépendances | Package avec faille connue |
| **PHPUnit** | Comportement du code (tests) | Route qui retourne 200 |
| **SonarCloud** | **Vue d'ensemble qualité** | Tout ce qui précède + métriques globales |

SonarCloud ne remplace pas ces outils : il les **complète** en fournissant un **tableau de bord centralisé** avec des métriques visuelles et un suivi dans le temps. C'est l'outil que votre chef de projet ou votre client consultera pour évaluer la qualité de votre livraison.

### Les 4 métriques clés de SonarCloud

SonarCloud évalue votre code selon 4 axes principaux :

```
🐛 Bugs            → Erreurs qui vont probablement causer un dysfonctionnement
🔓 Vulnérabilités  → Failles de sécurité potentielles
🧹 Code Smells     → Code qui fonctionne mais qui est mal écrit ou difficile à maintenir
📊 Couverture      → Pourcentage du code testé par vos tests automatisés
```

SonarCloud calcule également la **dette technique** : le temps estimé pour corriger tous les problèmes détectés. Par exemple, "2 jours de dette technique" signifie qu'il faudrait environ 2 jours de travail pour remettre le code au niveau de qualité attendu.

### La Quality Gate

La **Quality Gate** est un ensemble de conditions que votre code doit respecter pour être considéré comme "de qualité suffisante". Par défaut, SonarCloud utilise la Quality Gate "Sonar Way" :

- 0 nouveaux bugs
- 0 nouvelles vulnérabilités
- Couverture des nouveaux codes ≥ 80%
- Duplication des nouveaux codes < 3%

Si la Quality Gate passe → ✅ votre code est conforme.
Si elle échoue → ❌ il y a des problèmes à corriger avant de livrer.

---

## 🔧 Partie 2 — Créer un compte et configurer SonarCloud (10 min)

### Étape 1 : Inscription

1. Rendez-vous sur **[sonarcloud.io](https://sonarcloud.io)**
2. Cliquez sur **"Log in"** puis **"Log in with GitHub"**
3. Autorisez SonarCloud à accéder à votre compte GitHub
4. Vous arrivez sur le tableau de bord SonarCloud

### Étape 2 : Importer votre projet

1. Cliquez sur le bouton **"+"** (en haut à droite) → **"Analyze new project"**
2. Sélectionnez votre organisation GitHub (ou votre compte personnel)
3. Trouvez votre repository **BiblioTech** dans la liste
4. Cliquez sur **"Set Up"**
5. SonarCloud crée automatiquement le projet

> 💡 **Note :** SonarCloud est **gratuit** pour les projets publics (open source). Si votre repository est privé, vous pouvez le passer en public temporairement pour ce TP, ou utiliser le plan gratuit qui offre un quota de projets privés.

### Étape 3 : Choisir la méthode d'analyse

SonarCloud vous propose plusieurs méthodes. Choisissez **"With GitHub Actions"** :

1. Sur la page de configuration, sélectionnez **"GitHub Actions"**
2. SonarCloud vous donne un **token** (SONAR_TOKEN) — copiez-le précieusement
3. Notez également votre **Organization Key** et votre **Project Key** affichés à l'écran

### Étape 4 : Ajouter le secret dans GitHub

1. Allez sur votre repository GitHub → **Settings** → **Secrets and variables** → **Actions**
2. Cliquez sur **"New repository secret"**
3. Nom : `SONAR_TOKEN`
4. Valeur : collez le token copié depuis SonarCloud
5. Cliquez sur **"Add secret"**

> ⚠️ **Important :** Ne partagez jamais ce token. Il est lié à votre compte SonarCloud et donne accès à vos analyses.

---

## ⚙️ Partie 3 — Intégrer SonarCloud dans GitHub Actions (15 min)

### Étape 1 : Créer le fichier de configuration SonarCloud

À la racine de votre projet, créez le fichier `sonar-project.properties` :

```properties
# ============================================
# Configuration SonarCloud - BiblioTech Laravel
# ============================================

# Identification du projet (remplacez par vos valeurs)
sonar.organization=VOTRE_ORGANISATION
sonar.projectKey=VOTRE_PROJECT_KEY

# Nom affiché dans SonarCloud
sonar.projectName=BiblioTech Laravel
sonar.projectVersion=1.0

# Code source à analyser
sonar.sources=app,database,routes,resources
sonar.tests=tests

# Exclusions (fichiers à ne pas analyser)
sonar.exclusions=vendor/**,node_modules/**,storage/**,bootstrap/cache/**,public/**

# Configuration PHP
sonar.language=php
sonar.php.file.suffixes=php

# Couverture de tests (le fichier sera généré par PHPUnit)
sonar.php.coverage.reportPaths=coverage.xml

# Encodage
sonar.sourceEncoding=UTF-8
```

> 📝 **Remplacez** `VOTRE_ORGANISATION` et `VOTRE_PROJECT_KEY` par les valeurs affichées dans SonarCloud lors de la Partie 2.

### Étape 2 : Ajouter le job SonarCloud au workflow GitHub Actions

Ouvrez votre fichier `.github/workflows/ci.yml` (ou `tests.yml` créé dans [03-TP-TESTS-CICD.md](03-TP-TESTS-CICD.md)) et ajoutez un nouveau job :

```yaml
  # ===============================================
  # JOB : ANALYSE SONARCLOUD
  # ===============================================
  sonarcloud:
    name: 🔍 SonarCloud Analysis
    runs-on: ubuntu-latest
    needs: [test]

    steps:
    - name: 📥 Checkout code
      uses: actions/checkout@v4
      with:
        fetch-depth: 0  # Important : SonarCloud a besoin de l'historique Git complet

    - name: 🐘 Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: 8.3
        extensions: mbstring, xml, ctype, iconv, intl, pdo_sqlite
        coverage: xdebug

    - name: 📦 Install dependencies
      run: composer install --prefer-dist --no-progress --optimize-autoloader

    - name: 🔧 Setup Environment
      run: |
        cp .env.example .env
        php artisan key:generate
        touch database/database.sqlite
        php artisan migrate --force
        php artisan db:seed --force

    - name: 🧪 Run tests with coverage
      run: php artisan test --coverage-clover=coverage.xml

    - name: 🔍 SonarCloud Scan
      uses: SonarSource/sonarcloud-github-action@master
      env:
        GITHUB_TOKEN: ${{ secrets.GITHUB_TOKEN }}
        SONAR_TOKEN: ${{ secrets.SONAR_TOKEN }}
```

> 💡 **`fetch-depth: 0`** est essentiel : SonarCloud analyse l'historique Git pour distinguer le nouveau code du code existant.

> 💡 **`needs: [test]`** fait référence au job de tests créé dans le TP précédent. Adaptez le nom si votre job s'appelle autrement (ex: `tests`, `laravel-tests`).

### Étape 3 : Commit et push

```bash
# Ajouter les fichiers
git add sonar-project.properties
git add .github/workflows/ci.yml

# Commit
git commit -m "feat: ajout analyse SonarCloud dans le pipeline CI/CD"

# Push
git push origin <votre-branche>
```

### Étape 4 : Vérifier l'exécution

1. Allez sur GitHub → onglet **Actions**
2. Vous devriez voir votre pipeline en cours d'exécution
3. Le job **🔍 SonarCloud Analysis** doit apparaître
4. Attendez qu'il se termine (2-3 minutes environ)
5. Allez sur **[sonarcloud.io](https://sonarcloud.io)** pour voir les résultats

---

## 📊 Partie 4 — Interpréter les résultats (10 min)

### Le tableau de bord SonarCloud

Une fois l'analyse terminée, rendez-vous sur votre projet dans SonarCloud. Vous verrez un tableau de bord avec plusieurs sections.

### Comprendre les indicateurs

#### Quality Gate

En haut de la page, un badge indique si votre projet **passe** (✅ Passed) ou **échoue** (❌ Failed) la Quality Gate. C'est l'indicateur principal à surveiller.

#### Vue d'ensemble

Le dashboard affiche 4 métriques principales. Pour chacune, SonarCloud distingue le code **global** (tout le projet) et le **nouveau code** (modifié depuis la dernière analyse) :

```
┌─────────────────────────────────────────────────────┐
│  Quality Gate: ✅ Passed                            │
├─────────────┬─────────────┬──────────┬──────────────┤
│  🐛 Bugs    │ 🔓 Vulnér.  │ 🧹 Smells │ 📊 Coverage │
│     3       │     0       │    12    │    72%      │
│  1h dette   │  0h dette   │  3h dette│             │
└─────────────┴─────────────┴──────────┴──────────────┘
```

#### Détail des problèmes

En cliquant sur chaque métrique, vous accédez à la liste détaillée. Pour chaque problème, SonarCloud indique le fichier et la ligne concernés, la sévérité (Blocker, Critical, Major, Minor, Info), le temps estimé pour corriger, et une explication du problème avec la solution recommandée.

### Exercice : Analyser votre projet

Répondez aux questions suivantes en consultant votre tableau de bord SonarCloud :

1. Votre projet **passe-t-il** la Quality Gate ? Si non, pourquoi ?
2. Combien de **bugs** SonarCloud a-t-il détectés ? Quels fichiers sont concernés ?
3. Y a-t-il des **vulnérabilités** de sécurité ? Si oui, lesquelles ?
4. Quels sont les 3 **code smells** les plus fréquents ?
5. Quel est votre pourcentage de **couverture de tests** ?
6. Quelle est votre **dette technique** totale ?

> 📝 **Notez vos réponses** : elles alimenteront votre documentation technique pour les épreuves E5 et E6.

---

## 🛠️ Partie 5 — Corriger les problèmes (bonus)

### Corriger un bug ou un code smell

1. Dans SonarCloud, cliquez sur un problème pour voir le détail
2. Lisez l'explication et la suggestion de correction
3. Ouvrez le fichier concerné dans votre éditeur
4. Appliquez la correction
5. Commitez et poussez
6. Vérifiez dans SonarCloud que le problème a disparu après la nouvelle analyse

### Exemples de corrections courantes sur BiblioTech

#### Code Smell : fonction trop complexe

```php
// ❌ Avant : complexité cyclomatique trop élevée
public function index(Request $request)
{
    if ($request->has('search')) {
        if ($request->has('category')) {
            if ($request->get('sort') === 'asc') {
                $livres = Livre::where('titre', 'like', '%'.$request->search.'%')
                    ->where('category_id', $request->category)
                    ->orderBy('titre', 'asc')->get();
            } else {
                $livres = Livre::where('titre', 'like', '%'.$request->search.'%')
                    ->where('category_id', $request->category)
                    ->orderBy('titre', 'desc')->get();
            }
        } else {
            $livres = Livre::where('titre', 'like', '%'.$request->search.'%')->get();
        }
    } else {
        $livres = Livre::all();
    }
    return view('livres.index', compact('livres'));
}

// ✅ Après : utilisation de Query Builder avec chaînage conditionnel
public function index(Request $request)
{
    $livres = Livre::query()
        ->when($request->search, function ($query, $search) {
            $query->where('titre', 'like', "%{$search}%");
        })
        ->when($request->category, function ($query, $category) {
            $query->where('category_id', $category);
        })
        ->orderBy('titre', $request->get('sort', 'asc'))
        ->get();

    return view('livres.index', compact('livres'));
}
```

#### Vulnérabilité : injection SQL potentielle

```php
// ❌ Avant : concaténation directe dans la requête
$livres = DB::select("SELECT * FROM livres WHERE titre LIKE '%" . $request->search . "%'");

// ✅ Après : utilisation de paramètres liés (prepared statements)
$livres = DB::select("SELECT * FROM livres WHERE titre LIKE ?", ['%' . $request->search . '%']);

// ✅ Encore mieux : utiliser Eloquent (comme appris en séance 2)
$livres = Livre::where('titre', 'like', '%' . $request->search . '%')->get();
```

#### Code Smell : code dupliqué

```php
// ❌ Avant : logique de validation dupliquée dans store() et update()
public function store(Request $request)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'auteur' => 'required|string|max:255',
        'isbn' => 'required|string|max:13',
    ]);
    // ...
}

public function update(Request $request, Livre $livre)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'auteur' => 'required|string|max:255',
        'isbn' => 'required|string|max:13',
    ]);
    // ...
}

// ✅ Après : extraire dans un Form Request (cf. séance 3)
// app/Http/Requests/StoreLivreRequest.php
class StoreLivreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'isbn' => 'required|string|max:13',
        ];
    }
}
```

---

## 🏷️ Badge SonarCloud dans le README

Ajoutez les badges SonarCloud à votre `README.md` pour afficher les métriques directement sur GitHub :

```markdown
<!-- Badges SonarCloud -->
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=VOTRE_PROJECT_KEY&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=VOTRE_PROJECT_KEY)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=VOTRE_PROJECT_KEY&metric=bugs)](https://sonarcloud.io/summary/new_code?id=VOTRE_PROJECT_KEY)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=VOTRE_PROJECT_KEY&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=VOTRE_PROJECT_KEY)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=VOTRE_PROJECT_KEY&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=VOTRE_PROJECT_KEY)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=VOTRE_PROJECT_KEY&metric=coverage)](https://sonarcloud.io/summary/new_code?id=VOTRE_PROJECT_KEY)
```

> 📝 **Remplacez** `VOTRE_PROJECT_KEY` par la clé de votre projet SonarCloud.

---

## 📋 Compétences BTS SIO mobilisées

Ce TP mobilise plusieurs compétences du référentiel BTS SIO, exploitables pour le **tableau de synthèse E5** et la **présentation E6** :

### Bloc 1 — Support et mise à disposition de services informatiques (E5)

| Compétence | Application dans ce TP |
|------------|----------------------|
| **Gérer le patrimoine informatique** | Exploiter SonarCloud comme référentiel de normes de qualité ; vérifier le respect des règles d'utilisation des ressources numériques |
| **Travailler en mode projet** | Évaluer les indicateurs de suivi (métriques SonarCloud) ; analyser les écarts (dette technique) |
| **Mettre à disposition un service informatique** | Déployer SonarCloud ; réaliser des tests d'intégration via le pipeline CI/CD |
| **Organiser son développement professionnel** | Mettre en place un outil de veille sur la qualité du code ; développer des compétences DevOps |

### Bloc 2 — Conception et développement d'applications SLAM (E6)

| Compétence | Application dans ce TP |
|------------|----------------------|
| **Concevoir et développer une solution applicative** | Utiliser l'analyse statique pour améliorer la conception |
| **Assurer la maintenance corrective ou évolutive** | Identifier et corriger bugs, vulnérabilités et code smells |

---

## ✅ Checklist de validation

### Configuration

- [ ] Compte SonarCloud créé et lié à GitHub
- [ ] Projet BiblioTech importé dans SonarCloud
- [ ] Token `SONAR_TOKEN` ajouté dans les secrets GitHub
- [ ] Fichier `sonar-project.properties` créé à la racine du projet

### Pipeline CI/CD

- [ ] Job `sonarcloud` ajouté dans le workflow GitHub Actions
- [ ] Pipeline exécuté avec succès (job vert dans l'onglet Actions)
- [ ] Résultats visibles dans le dashboard SonarCloud

### Analyse

- [ ] Quality Gate consultée et comprise
- [ ] Métriques principales relevées (bugs, vulnérabilités, code smells, couverture)
- [ ] Dette technique identifiée
- [ ] Au moins 1 problème corrigé (bonus)

### Documentation

- [ ] Badges SonarCloud ajoutés au README
- [ ] Captures d'écran du dashboard pour le portfolio (recommandé)

---

## 🎓 Pour aller plus loin

### Décoration des Pull Requests

SonarCloud peut commenter automatiquement vos Pull Requests sur GitHub pour indiquer si le nouveau code respecte la Quality Gate. Cette fonctionnalité est activée par défaut quand vous utilisez GitHub Actions. Quand vous créez une PR, SonarCloud ajoutera un commentaire avec le statut complet.

### SonarLint dans votre IDE

**SonarLint** est une extension gratuite pour VS Code (ou PHPStorm) qui détecte les problèmes SonarCloud **en temps réel** pendant que vous codez, avant même de commit :

1. Installez l'extension **SonarLint** dans VS Code
2. Connectez-la à votre projet SonarCloud (Settings → SonarLint → Connected Mode)
3. Les problèmes apparaissent directement dans votre éditeur avec des explications

C'est comme avoir un correcteur orthographique, mais pour la qualité du code.

### Profils de qualité personnalisés

Dans SonarCloud, vous pouvez créer des profils de qualité adaptés à votre contexte. Par exemple, désactiver certaines règles trop strictes pour un projet d'apprentissage, ou activer des règles spécifiques à Laravel.

---

> 💡 **Conseil pour l'épreuve E6 :** Lors de votre présentation, montrer que vous utilisez SonarCloud démontre une **démarche professionnelle de qualité logicielle**. Les jurys apprécient les candidats qui ne se contentent pas de coder, mais qui s'assurent aussi de la qualité de leur production. Pensez à inclure des captures d'écran du dashboard SonarCloud dans votre documentation technique.

---

Prêt pour le déploiement ? 🚀 → [04-TP-DEPLOYMENT.md](04-TP-DEPLOYMENT.md)
