# 📚 Synthèse Complète — SP Laravel BiblioTech BTS SIO SLAM

> **Document de synthèse pour génération vidéo NotebookLM**
> Formation Laravel BiblioTech — 5 séances × 3h = 15h
> BTS SIO SLAM — Session 2026

---

## 🎯 Présentation Générale de la SP

### Qu'est-ce que BiblioTech ?

BiblioTech est une **application de gestion de bibliothèque** développée avec le framework **Laravel 12** et **PHP 8.3**. C'est le projet fil rouge de la Situation Professionnelle (SP) qui accompagne les étudiants BTS SIO option SLAM tout au long de leur formation au développement web.

Le projet est construit de manière **progressive et incrémentale** : chaque séance ajoute une couche de complexité sur la précédente, partant des fondations MVC jusqu'au déploiement en production. L'étudiant part de zéro et termine avec une application complète, testée, analysée en qualité de code, et déployable — un vrai projet à présenter en entretien ou lors des épreuves E5 et E6.

### Pourquoi une bibliothèque ?

Le domaine de la gestion de bibliothèque est un choix pédagogique pertinent car il combine des entités simples à comprendre (Livres, Utilisateurs, Emprunts, Catégories), des relations claires entre ces entités, et des fonctionnalités variées qui couvrent tout le spectre du développement web : CRUD, recherche, authentification, rôles, notifications.

### Technologies utilisées

L'environnement technique repose sur Laravel 12, PHP 8.3, SQLite comme base de données (simple et portable, sans serveur séparé), Bootstrap 5 pour l'interface, Git et GitHub pour le versionning, GitHub Actions pour l'intégration continue, et SonarCloud pour l'analyse de qualité du code. L'installation se fait soit en local, soit via GitHub Codespaces pour un démarrage en moins d'une minute.

### Lien avec les épreuves BTS SIO

Cette SP alimente directement deux épreuves majeures du BTS SIO :

**Épreuve E5 — Tableau de synthèse (Bloc 1)** : Le projet BiblioTech permet de cocher les compétences du Bloc 1 "Support et mise à disposition de services informatiques". Chaque séance contribue à des compétences comme "Gérer le patrimoine informatique", "Travailler en mode projet", "Mettre à disposition un service informatique" ou "Organiser son développement professionnel". Le tableau de synthèse E5 demande de lister les réalisations professionnelles avec les compétences mises en œuvre, les périodes de réalisation, et l'URL du portfolio.

**Épreuve E6 — CCF SLAM (Bloc 2)** : Le projet constitue une réalisation professionnelle pour l'épreuve E6 "Conception et développement d'applications". L'étudiant doit présenter deux réalisations professionnelles, expliquer ses choix techniques lors d'un entretien d'explicitation de 20 minutes, puis réaliser une recette de la solution pendant 20 minutes. Les compétences évaluées sont : concevoir et développer une solution applicative, assurer la maintenance corrective ou évolutive, et gérer les données.

---

## 📅 Organisation Pédagogique

### Structure de chaque séance

Chaque séance suit une organisation standardisée avec des documents numérotés :

- **00-README** : Vue d'ensemble et index de la séance
- **01-CONCEPTS** : Théorie et concepts fondamentaux (15-20 min de lecture)
- **02-GLOSSAIRE** : Vocabulaire technique et commandes essentielles
- **03-TP guidé** : Travail pratique pas à pas avec code fourni
- **04-TP approfondissement** : Exercices complémentaires guidés
- **05-TP autonome** : Exercices en autonomie avec consignes uniquement
- **06-EVALUATION** : Test de compétences noté
- **07-AUTO-EVALUATION** : Grille d'auto-évaluation avec checklist

Les solutions complètes sont disponibles dans un dossier dédié pour chaque séance.

### Progression globale

La formation suit une progression logique sur 5 séances de 3 heures. Les séances 1 à 3 ont été réalisées au semestre 1 (avant le stage). La reprise au semestre 2 (post-stage) commence à la séance 4, les séances 1 à 3 servant de référence et de révision si besoin.

### Validation de passage

Pour passer à la séance suivante, l'étudiant doit obtenir une note supérieure ou égale à 12/20 à l'évaluation, avoir terminé les exercices principaux, et démontrer la compréhension des concepts clés.

---

## 🎯 Séance 1 — Fondations Laravel et MVC

### Synthèse

La première séance pose les bases fondamentales de Laravel et de l'architecture MVC (Model-View-Controller). L'étudiant découvre comment une application web moderne est structurée et apprend à créer ses premières pages.

### Objectifs pédagogiques

L'objectif principal est de comprendre le fonctionnement de Laravel et de créer ses premières pages web dynamiques. Concrètement, l'étudiant apprend à installer l'environnement de développement (PHP + Laravel avec SQLite), à comprendre l'architecture MVC et le flux de données (URL → Route → Contrôleur → Vue), à créer des routes pour accéder aux pages, et à utiliser le moteur de templates Blade pour afficher du contenu dynamique.

### Concepts clés abordés

**Le pattern MVC** est au cœur de cette séance. Le Modèle gère les données, la Vue gère l'affichage (ce que voit l'utilisateur), et le Contrôleur gère la logique (il fait le lien entre les deux). Quand un utilisateur tape une URL, Laravel cherche la route correspondante, appelle le contrôleur associé, qui prépare les données et les transmet à une vue Blade pour l'affichage.

**Les routes Laravel** définissent les URL accessibles de l'application. On les déclare dans le fichier `routes/web.php`. Chaque route associe une URL et une méthode HTTP (GET, POST...) à une action dans un contrôleur.

**Blade** est le moteur de templates de Laravel. Il permet d'écrire du HTML avec des directives spéciales comme `@foreach`, `@if`, `{{ $variable }}` pour injecter des données dynamiques. L'héritage de templates avec `@extends` et `@section` permet de factoriser le code HTML commun (header, footer, navigation).

### Exercices pratiques

Les étudiants installent Laravel avec `php artisan serve`, créent une route `/contact`, affichent une liste de livres depuis des données statiques, personnalisent la page d'accueil et mettent en place la navigation entre les pages.

### Critères de validation

L'application fonctionne avec SQLite, au moins 3 routes sont créées et fonctionnelles, et l'étudiant comprend le flux : URL → Contrôleur → Vue.

### Compétences BTS SIO mobilisées

Cette séance contribue aux compétences B2.1.4 (définir les spécifications d'une solution applicative), B2.1.5 (prototyper une solution applicative — le MVP est créé dès cette séance), et B2.1.6 (programmer ou adapter des composants logiciels).

---

## 🗄️ Séance 2 — Base de Données SQLite et Eloquent

### Synthèse

La deuxième séance marque le passage des données statiques (écrites en dur dans le code) à une vraie base de données. L'étudiant apprend à utiliser SQLite avec l'ORM Eloquent de Laravel pour stocker, lire et manipuler des données de manière professionnelle.

### Objectifs pédagogiques

L'objectif est de remplacer les données en dur par une base de données SQLite et de maîtriser Eloquent, l'ORM de Laravel. L'étudiant apprend à créer des tables avec les migrations, à interagir avec la base via les modèles Eloquent, à définir des relations entre les tables (un livre appartient à une catégorie), et à peupler la base avec des données de test via les seeders.

### Concepts clés abordés

**SQLite** est un système de base de données léger qui stocke tout dans un seul fichier (`database/database.sqlite`). Pas besoin d'installer un serveur séparé comme MySQL ou PostgreSQL. C'est idéal pour l'apprentissage et suffisant pour couvrir 100% du programme BTS SIO.

**Les migrations** sont des fichiers PHP qui décrivent la structure des tables. Elles permettent de versionner le schéma de la base de données avec Git. On crée les tables avec `php artisan migrate` et on peut revenir en arrière avec `php artisan migrate:rollback`.

**Eloquent ORM** est la couche d'abstraction de Laravel pour interagir avec la base de données en PHP objet au lieu d'écrire du SQL brut. Chaque table a un modèle associé (table `livres` → modèle `Livre`). On peut lire avec `Livre::all()`, créer avec `Livre::create([...])`, chercher avec `Livre::find($id)`.

**Les relations Eloquent** permettent de lier les modèles entre eux. Par exemple, un livre appartient à une catégorie (`belongsTo`) et une catégorie a plusieurs livres (`hasMany`). On peut alors accéder à `$livre->categorie->nom` directement.

**Les seeders** remplissent la base avec des données de test. Le `LivreSeeder` crée plus de 20 livres de démonstration pour que l'application ait du contenu dès l'installation.

**Les scopes** sont des filtres réutilisables sur les requêtes Eloquent. Par exemple, un scope `disponible()` filtre les livres disponibles, et un scope `recherche($terme)` permet la recherche par mot-clé.

### Exercices pratiques

Les étudiants créent les tables `livres` et `categories` dans SQLite, développent les modèles `Livre` et `Categorie` avec leurs relations, affichent les livres depuis la base de données SQLite, et ajoutent des données via les seeders.

### Critères de validation

La base SQLite est fonctionnelle, les données s'affichent depuis SQLite (plus de données statiques), les relations entre livres et catégories fonctionnent.

### Compétences BTS SIO mobilisées

Cette séance développe les compétences B2.1.3 (modéliser et créer une base de données), B2.1.6 (programmer des composants logiciels), et introduit le pipeline CI/CD avec GitHub Actions pour automatiser les tests à chaque push.

---

## 🎭 Séance 3 — Contrôleurs Resource et Vues Avancées

### Synthèse

La troisième séance est la plus riche en termes de développement d'interface. L'étudiant passe d'une application en lecture seule à une application CRUD complète (Create, Read, Update, Delete) avec une interface utilisateur moderne et une validation robuste des données.

### Objectifs pédagogiques

L'objectif est de maîtriser les contrôleurs resource et de développer un système de vues sophistiqué. L'étudiant apprend à générer un contrôleur resource avec les 7 actions CRUD automatiques, à créer des formulaires de création et d'édition, à valider les données côté serveur, et à fournir du feedback à l'utilisateur via les messages flash.

### Concepts clés abordés

**Les contrôleurs Resource** sont des contrôleurs Laravel qui implémentent automatiquement les 7 actions CRUD standard : `index` (liste), `create` (formulaire de création), `store` (enregistrer), `show` (détail), `edit` (formulaire de modification), `update` (modifier), `destroy` (supprimer). Une seule ligne de route `Route::resource('livres', LivreController::class)` crée toutes les URLs nécessaires.

**Le Route Model Binding** est un mécanisme de Laravel qui injecte automatiquement le modèle correspondant dans les méthodes du contrôleur. Au lieu d'écrire `Livre::find($id)`, on déclare directement `public function show(Livre $livre)` et Laravel retrouve le livre automatiquement depuis l'URL.

**La validation Laravel** permet de définir des règles de validation côté serveur pour chaque champ de formulaire. Par exemple : `'titre' => 'required|min:3|max:255'`. Si la validation échoue, Laravel redirige automatiquement vers le formulaire avec les erreurs affichées.

**Les messages Flash** sont des messages temporaires stockés en session qui s'affichent une seule fois après une action (création, modification, suppression). Ils fournissent un retour visuel à l'utilisateur : "Livre créé avec succès", "Livre supprimé", etc.

**Les composants Blade** permettent de créer des éléments réutilisables, comme une carte de livre (`livre-card.blade.php`), qu'on peut inclure dans plusieurs vues sans dupliquer le code.

**L'interface responsive** avec Bootstrap 5 garantit que l'application s'adapte à tous les écrans (mobile, tablette, desktop).

### Exercices pratiques

Les étudiants génèrent un contrôleur resource complet, créent toutes les vues CRUD (index, show, create, edit), implémentent la validation avec messages d'erreur personnalisés, développent une interface responsive, et ajoutent des composants Blade réutilisables.

### Critères de validation

Le contrôleur resource a ses 7 méthodes fonctionnelles, l'interface utilisateur est complète et moderne, la validation côté serveur est robuste, la navigation est fluide entre toutes les pages, et les messages flash sont appropriés pour chaque action.

### Compétences BTS SIO mobilisées

Cette séance couvre les compétences B2.1.5 (prototyper — approche itérative avec un MVP qui s'enrichit), B2.1.6 (programmer — les 7 actions CRUD), et ajoute la maîtrise de la validation et de l'UX.

---

## 🔐 Séance 4 — Authentification et Autorisations

### Synthèse

La quatrième séance porte sur la sécurité de l'application. L'étudiant implémente un système complet d'authentification (qui êtes-vous ?) et d'autorisation (que pouvez-vous faire ?). C'est une séance cruciale car la sécurité est un pilier du développement professionnel et un sujet majeur de l'épreuve E6.

### Objectifs pédagogiques

L'étudiant apprend à implémenter le système d'authentification Laravel (login, register, logout), à gérer trois niveaux de rôles (Admin, Bibliothécaire, Utilisateur), à protéger les routes avec des middleware d'authentification, à créer des formulaires sécurisés, à gérer les sessions utilisateur avec la fonctionnalité "Se souvenir de moi", et à se protéger contre les attaques courantes (CSRF, brute-force).

### Concepts clés abordés

**Authentification vs Autorisation** : ce sont deux concepts distincts. L'authentification vérifie l'identité de l'utilisateur (qui êtes-vous ? → vérification email + mot de passe). L'autorisation vérifie les permissions (pouvez-vous faire cette action ? → vérification du rôle). Les deux sont nécessaires pour une application sécurisée.

**Le système de sessions** est au cœur de l'authentification web. Après un login réussi, Laravel crée un identifiant de session unique (token aléatoire), l'envoie au navigateur dans un cookie, et à chaque requête suivante, le navigateur renvoie ce cookie. Laravel peut ainsi savoir quel utilisateur est connecté avec `Auth::user()`. Les sessions peuvent être stockées en fichier (par défaut, simple pour le développement), en base de données (pour la production), ou en mémoire avec Redis (haute performance).

**Le hashage des mots de passe** est une règle de sécurité absolue : on ne stocke JAMAIS un mot de passe en clair dans la base de données. Laravel utilise bcrypt pour transformer le mot de passe en une chaîne irréversible. Pour vérifier, on utilise `Hash::check($password, $user->password)` qui compare le hash sans jamais connaître le mot de passe original.

**Les middleware** sont des filtres qui interceptent les requêtes HTTP avant qu'elles n'atteignent le contrôleur. Le middleware `auth` vérifie que l'utilisateur est connecté. Un middleware de rôle vérifie que l'utilisateur a le bon niveau d'accès (admin, bibliothécaire, etc.). Si la vérification échoue, l'utilisateur est redirigé ou reçoit une erreur 403 Forbidden.

**La protection CSRF** (Cross-Site Request Forgery) empêche les attaques où un site malveillant tente de soumettre un formulaire à la place de l'utilisateur. Chaque formulaire Laravel doit inclure la directive `@csrf` qui ajoute un token secret vérifié côté serveur.

**Le système de rôles** permet de différencier les utilisateurs. Un Admin a accès à tout (gestion des utilisateurs, configuration). Un Bibliothécaire peut gérer les livres et les emprunts. Un Utilisateur standard peut consulter le catalogue et emprunter. L'affichage s'adapte au rôle avec des directives Blade conditionnelles.

### Exercices pratiques

Les étudiants créent les pages d'inscription et de connexion, implémentent la protection des pages admin via middleware, ajoutent l'affichage conditionnel selon le rôle (un admin voit les boutons de suppression, pas un utilisateur standard), et implémentent la déconnexion sécurisée.

### Extensions possibles

Pour les étudiants avancés, la séance propose des extensions : permissions granulaires (chaque rôle a des permissions spécifiques), audit logging (journaliser toutes les actions sensibles), authentification à deux facteurs (2FA), vérification d'email, et gestion des sessions actives.

### Critères de validation

Le système d'authentification est complet (register, login, logout), les pages protégées sont fonctionnelles (redirection si non connecté), et la différenciation admin/utilisateur est opérationnelle.

### Compétences BTS SIO mobilisées

Cette séance couvre les compétences C2.2 et C2.3 (concevoir et développer une solution applicative), C4.1 (gérer le patrimoine informatique), ainsi que les savoirs S2.1 (programmation objet), S2.2 (conception et développement) et S4.2 (sécurité informatique).

---

## 🚀 Séance 5 — Production, Déploiement et Tests

### Synthèse

La cinquième et dernière séance est la plus ambitieuse. Elle couvre le cycle complet du passage en production : tests automatisés, intégration continue, analyse de qualité du code, déploiement, et monitoring. **Cette séance n'a pas encore été réalisée avec les étudiants**, elle nécessite donc une attention particulière pour bien comprendre chaque étape.

### Pourquoi cette séance est essentielle

Jusqu'à la séance 4, les étudiants ont développé une application complète mais qui tourne uniquement en local sur leur machine. La séance 5 répond à la question : "comment passer d'un projet local à une application professionnelle en production ?" C'est exactement ce qui différencie un projet scolaire d'un projet professionnel, et c'est ce que les jurys d'examen apprécient particulièrement lors de l'épreuve E6.

### Objectifs pédagogiques détaillés

L'étudiant doit maîtriser six grands domaines à l'issue de cette séance :

1. **Les tests automatisés** : écrire des tests qui vérifient automatiquement que l'application fonctionne correctement
2. **L'intégration continue (CI/CD)** : configurer un pipeline GitHub Actions qui exécute les tests à chaque push
3. **L'analyse de qualité de code (SonarCloud)** : détecter automatiquement les bugs, vulnérabilités et mauvaises pratiques
4. **La configuration production** : optimiser l'application pour un environnement réel
5. **Le déploiement** : mettre l'application en ligne sur un serveur
6. **Le monitoring** : surveiller l'application en production pour détecter les erreurs

### Partie 1 — Les Tests Automatisés (Détail)

#### Pourquoi tester ?

Les tests automatisés sont le filet de sécurité du développeur. Sans tests, chaque modification du code peut casser quelque chose ailleurs sans qu'on s'en rende compte. Avec des tests, on exécute une commande (`php artisan test`) et en quelques secondes, on sait si tout fonctionne.

#### Deux types de tests

Les **tests unitaires** (Unit Tests) testent une classe ou une méthode isolée. Par exemple, on teste que le modèle `Livre` calcule correctement si un livre est disponible. C'est rapide et ciblé. Les fichiers sont dans `tests/Unit/`.

Les **tests fonctionnels** (Feature Tests) testent une route complète, du début à la fin. Par exemple, on simule une requête GET sur `/livres` et on vérifie qu'on obtient un code 200, que la page contient le mot "Livres", et que les livres de la base sont affichés. Cela teste le contrôleur, la vue et la base de données ensemble. Les fichiers sont dans `tests/Feature/`.

#### Assertions principales

Les assertions sont les vérifications dans un test. Les plus courantes sont :
- `assertStatus(200)` : vérifie le code HTTP de la réponse
- `assertSee('texte')` : vérifie qu'un texte apparaît dans la page
- `assertDatabaseHas('livres', ['titre' => 'Mon livre'])` : vérifie qu'un enregistrement existe en base
- `assertRedirect('/login')` : vérifie la redirection

#### Trait RefreshDatabase

Le trait `RefreshDatabase` est essentiel dans les tests : il remet la base de données à zéro avant chaque test. Ainsi, chaque test part d'un état propre et ne dépend pas des autres tests.

#### Objectif de couverture

L'objectif est d'atteindre plus de 70% de couverture de code (code coverage). Cela signifie que 70% du code de l'application est exécuté par au moins un test. On génère le rapport de couverture avec `php artisan test --coverage`.

### Partie 2 — CI/CD avec GitHub Actions (Détail)

#### Qu'est-ce que CI/CD ?

CI signifie Continuous Integration (intégration continue) : à chaque push sur GitHub, les tests sont exécutés automatiquement. Si un test échoue, on est alerté immédiatement. CD signifie Continuous Deployment (déploiement continu) : si tous les tests passent, l'application est déployée automatiquement en production.

#### Le fichier workflow

Le pipeline CI/CD est défini dans un fichier YAML `.github/workflows/ci.yml`. Ce fichier décrit les étapes à exécuter : installer PHP 8.3, installer les dépendances Composer, copier le fichier `.env`, générer la clé d'application, créer la base SQLite, exécuter les migrations, et lancer les tests. Si tout passe (badge vert), le code est considéré comme sûr.

#### Déclenchement

Le pipeline se déclenche automatiquement sur chaque `push` et chaque `pull_request`. On peut voir l'état des exécutions dans l'onglet "Actions" de GitHub.

### Partie 3 — SonarCloud et Qualité de Code (Détail)

#### Qu'est-ce que SonarCloud ?

SonarCloud est un service en ligne gratuit pour les projets open-source qui analyse automatiquement la qualité du code source. Il détecte quatre types de problèmes :
- Les **bugs** : du code qui ne fonctionne pas correctement
- Les **vulnérabilités** : des failles de sécurité potentielles
- Les **code smells** : du code qui fonctionne mais qui est mal écrit (difficile à maintenir)
- La **dette technique** : le temps estimé pour corriger tous les code smells

#### Quality Gate

La Quality Gate est le verdict final : votre code passe (Passed ✅) ou échoue (Failed ❌). C'est comme un contrôle qualité à l'usine. Par défaut, la Quality Gate vérifie que la couverture du nouveau code est supérieure à 80%, qu'il n'y a pas de nouvelles vulnérabilités, et que le ratio de duplication est inférieur à 3%.

#### Configuration dans le projet

La configuration SonarCloud nécessite trois éléments :
1. Un fichier `sonar-project.properties` à la racine du projet qui définit la clé du projet, le nom, les sources à analyser, et les exclusions
2. Un secret `SONAR_TOKEN` dans les paramètres GitHub du repository
3. Un job `sonarcloud` dans le workflow GitHub Actions qui exécute l'analyse après les tests

#### Intérêt pour l'examen

Pour l'épreuve E6, montrer que l'on utilise SonarCloud démontre une **démarche professionnelle de qualité logicielle**. Les jurys apprécient les candidats qui ne se contentent pas de coder mais qui s'assurent aussi de la qualité de leur production. Il est recommandé d'inclure des captures d'écran du dashboard SonarCloud dans la documentation technique et d'ajouter les badges SonarCloud au README du projet.

### Partie 4 — Configuration Production (Détail)

#### Différences développement vs production

En développement, `APP_DEBUG=true` affiche les erreurs détaillées. En production, `APP_DEBUG=false` est **obligatoire** car les messages d'erreur détaillés exposent la structure du code, les chemins de fichiers, les configurations — des informations précieuses pour un attaquant.

#### Optimisations Laravel

Quatre commandes d'optimisation sont essentielles avant le déploiement :
- `php artisan config:cache` : met en cache la configuration (plus besoin de lire les fichiers .env à chaque requête)
- `php artisan route:cache` : met en cache les routes (accélère la résolution des URL)
- `php artisan view:cache` : compile les vues Blade en PHP pur
- `composer install --optimize-autoloader --no-dev` : optimise le chargement des classes et supprime les dépendances de développement

#### HTTPS obligatoire

En production, toutes les communications doivent être chiffrées avec HTTPS (certificat SSL/TLS). Let's Encrypt fournit des certificats gratuits. Sans HTTPS, les mots de passe et données sensibles transitent en clair sur le réseau.

### Partie 5 — Déploiement (Détail)

#### Options de déploiement

Plusieurs options sont possibles selon le contexte : un hébergement mutualisé (simple mais limité), un VPS (Virtual Private Server — plus de contrôle), Heroku (Platform-as-a-Service, déploiement simplifié), ou un serveur dédié.

#### Processus de déploiement type

Le déploiement suit un processus standard : cloner le repository sur le serveur, installer les dépendances avec Composer, configurer le fichier `.env` de production (avec les vrais identifiants de base de données, les clés API, etc.), exécuter les migrations, lancer les optimisations, et configurer le serveur web (Nginx ou Apache) pour pointer vers le dossier `public/` de Laravel.

#### Rollback

Un plan de rollback est essentiel : si le déploiement casse l'application, on doit pouvoir revenir à la version précédente rapidement. Git permet de revenir à n'importe quel commit antérieur. Les tags Git sont utilisés pour marquer les versions stables (v1.0, v1.1, etc.).

### Partie 6 — Monitoring (Détail)

#### Pourquoi surveiller ?

Une application en production peut rencontrer des erreurs que personne ne signale (les utilisateurs quittent souvent le site sans le dire). Le monitoring permet de détecter et corriger les problèmes avant qu'ils n'impactent trop d'utilisateurs.

#### Outils de monitoring

Les **logs Laravel** enregistrent automatiquement les erreurs dans `storage/logs/laravel.log`. On peut configurer différents canaux de logs (fichier, base de données, service externe).

**Sentry** est un service d'error tracking qui capture automatiquement les exceptions, les regroupe par type, et envoie des alertes par email ou Slack. L'intégration avec Laravel se fait en quelques lignes de configuration.

Un **Health Check** est une route dédiée (`/health/deep`) qui vérifie que tous les composants de l'application fonctionnent : connexion à la base de données, accès au cache, permissions d'écriture sur le disque. Les services de monitoring externes appellent cette URL régulièrement pour vérifier que l'application est en ligne.

### Pipeline complet de la Séance 5

Le pipeline complet de cette séance représente le cycle de vie professionnel d'une application :

```
Développement local → Écriture des tests → Push sur GitHub
→ GitHub Actions exécute les tests automatiquement
→ SonarCloud analyse la qualité du code
→ Si tout passe : déploiement sur le serveur de staging
→ Tests de validation sur staging
→ Déploiement en production
→ Monitoring continu des erreurs et performances
```

### Livrables attendus

À la fin de cette séance, l'étudiant doit avoir : une suite de tests développée (objectif 50+ tests), un pipeline GitHub Actions configuré et fonctionnel, SonarCloud configuré avec Quality Gate, l'application déployée et accessible en ligne, le monitoring et les alertes en place, et une documentation complète du processus.

### Critères de validation

Les tests automatiques passent avec plus de 70% de couverture, l'application est en ligne et accessible, le pipeline CI/CD est fonctionnel (badge vert), la Quality Gate SonarCloud est passée, et l'étudiant comprend les choix SQLite vs PostgreSQL et peut les justifier.

### Compétences BTS SIO mobilisées (Blocs 1 et 2)

**Bloc 1 (E5)** :
- Gérer le patrimoine informatique : exploiter SonarCloud comme référentiel de normes qualité
- Travailler en mode projet : évaluer les indicateurs de suivi (métriques SonarCloud), analyser les écarts (dette technique)
- Mettre à disposition un service informatique : déployer SonarCloud, réaliser des tests d'intégration via CI/CD
- Organiser son développement professionnel : mettre en place un outil de veille qualité, développer des compétences DevOps

**Bloc 2 (E6)** :
- Concevoir et développer une solution applicative : utiliser l'analyse statique pour améliorer la conception
- Assurer la maintenance corrective ou évolutive : identifier et corriger bugs, vulnérabilités et code smells

### Grille de notation de la Séance 5

| Compétence | Points |
|---|---|
| Tests unitaires fonctionnels (coverage > 70%) | 3 |
| Tests Feature complets (routes principales) | 3 |
| CI/CD pipeline configuré (GitHub Actions) | 2 |
| Déploiement production (app accessible) | 3 |
| Configuration sécurité (DEBUG=false, HTTPS) | 2 |
| Monitoring et logs (accessibles) | 2 |
| Extensions réalisées (bonus) | 1 |
| **TOTAL** | **/16** |

Score : 14-16 Excellent, 12-13 Bon, 10-11 Satisfaisant, moins de 10 À revoir.

---

## 📊 Récapitulatif des 5 Séances

| Séance | Thème | Concepts clés | Livrable |
|--------|-------|---------------|----------|
| **S1** | Fondations Laravel & MVC | Routes, Contrôleurs, Blade, MVC | Application avec 3 routes fonctionnelles |
| **S2** | Base de Données & Eloquent | Migrations, Modèles, Relations, Seeders, Scopes | Base SQLite avec données dynamiques |
| **S3** | CRUD & Vues Avancées | Contrôleurs Resource, Validation, Messages Flash, Composants Blade | Application CRUD complète avec interface responsive |
| **S4** | Authentification & Sécurité | Auth, Sessions, Hashage, Middleware, Rôles, CSRF | Système de login avec 3 niveaux de rôles |
| **S5** | Production & Déploiement | Tests, CI/CD, SonarCloud, Déploiement, Monitoring | Application testée, analysée et déployée en production |

---

## 🎓 Objectif Final

À la fin des 5 séances, chaque étudiant dispose d'une application Laravel complète et sécurisée, avec des tests automatisés qui passent, une analyse qualité SonarCloud avec Quality Gate, l'application déployée en production, un monitoring et des alertes actifs, et une documentation professionnelle. C'est un vrai projet à présenter en entretien d'embauche et lors des épreuves E5 et E6 du BTS SIO.

---

*Document généré pour utilisation avec NotebookLM — Formation BiblioTech Laravel SP — BTS SIO SLAM Session 2026*
