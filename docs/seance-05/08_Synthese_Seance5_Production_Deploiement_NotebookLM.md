# 🚀 Séance 5 — Production, Déploiement et Tests

> **Document de synthèse détaillé pour génération vidéo NotebookLM**
> SP Laravel BiblioTech — Séance finale
> BTS SIO SLAM — Session 2026

---

## Contexte : pourquoi cette séance est décisive

Cette cinquième et dernière séance de la SP Laravel BiblioTech est la plus ambitieuse du parcours. Elle n'a pas encore été réalisée avec les étudiants et arrive à un moment stratégique : juste avant l'épreuve CCF E6 SLAM prévue du 30 mars au 1er avril 2026. Tout ce qui sera vu ici alimente directement la préparation de cette épreuve.

Jusqu'à la séance 4, les étudiants ont construit une application complète : architecture MVC en séance 1, base de données SQLite et Eloquent en séance 2, interface CRUD avec validation en séance 3, authentification et système de rôles en séance 4. Mais tout cela tourne en local, sur la machine de l'étudiant. La séance 5 pose la question fondamentale du métier de développeur : comment passer d'un projet local à une application professionnelle en production ?

C'est exactement ce qui différencie un projet scolaire d'un projet professionnel, et c'est ce que les jurys d'examen apprécient lors de l'épreuve E6. Un étudiant qui peut montrer qu'il teste son code automatiquement, qu'il analyse la qualité avec SonarCloud, et qu'il sait déployer, a un avantage considérable.

---

## Organisation pédagogique de la séance

La séance 5 suit la même structure standardisée que les précédentes, avec des documents numérotés de 00 à 07. La partie théorique comprend le document 01-CONCEPTS-PRODUCTION qui couvre l'architecture production, les tests, le déploiement, le monitoring et le versioning, et le document 02-GLOSSAIRE-DEPLOYMENT avec la terminologie DevOps et les commandes essentielles. La partie pratique comprend trois TP : le 03-TP-TESTS-CICD pour l'écriture de tests et la configuration de GitHub Actions (environ 60 minutes), le 03B-TP-SONARCLOUD qui est un ajout récent dédié à l'analyse de qualité de code (environ 45 minutes), et le 04-TP-DEPLOYMENT pour la préparation et le déploiement en production (environ 75 minutes). Enfin, le 05-TP-PRATIQUE-EXERCICES propose des exercices autonomes intégrant tout le cycle. La partie évaluation comprend le 06-EVALUATION-COMPETENCES et le 07-AUTO-EVALUATION.

Trois parcours sont possibles selon le niveau du groupe. Le parcours standard dure environ 6 à 7 heures. Le parcours rapide pour les étudiants à l'aise prend environ 4 heures. Le parcours d'approfondissement, pour ceux qui veulent aller plus loin avec des extensions comme Laravel Dusk ou le déploiement Blue-Green, peut aller jusqu'à 9 heures.

---

## Les tests automatisés : le filet de sécurité du développeur

### Pourquoi tester son code

Les tests automatisés sont le premier pilier de cette séance. Sans tests, chaque modification du code peut casser quelque chose ailleurs sans que personne s'en rende compte. Avec des tests, on exécute une commande et en quelques secondes on sait si tout fonctionne. C'est comme un contrôle technique pour une voiture : on vérifie systématiquement que tous les composants fonctionnent avant de prendre la route.

Dans le contexte de BiblioTech, imaginez qu'un étudiant modifie le contrôleur des livres pour ajouter un filtre de recherche. Sans tests, il ne sait pas si sa modification a cassé l'affichage de la liste, la création d'un livre, ou la suppression. Avec des tests, il lance `php artisan test` et voit immédiatement si quelque chose ne fonctionne plus.

### Les deux types de tests dans Laravel

Laravel distingue deux catégories de tests, chacune avec son rôle spécifique.

Les tests unitaires, ou Unit Tests, testent une classe ou une méthode de manière isolée. Par exemple, on teste que le modèle Livre calcule correctement si un livre est disponible, ou que le modèle User retourne bien le bon rôle. Ces tests sont rapides à exécuter parce qu'ils ne font pas appel à la base de données ni au serveur web. Ils se trouvent dans le dossier `tests/Unit/`. Un test unitaire typique pour BiblioTech vérifie qu'un utilisateur peut être créé avec les bons attributs, ou que les scopes Eloquent comme `disponible()` et `recherche()` fonctionnent correctement sur le modèle Livre.

Les tests fonctionnels, ou Feature Tests, testent une route complète du début à la fin. On simule une requête HTTP, par exemple un GET sur `/livres`, et on vérifie que la réponse a le bon code HTTP, que la page contient le contenu attendu, et que les données de la base sont correctement affichées. Ces tests sont plus lents car ils impliquent le contrôleur, la vue, la base de données, et parfois l'authentification, mais ils sont plus proches de l'expérience réelle de l'utilisateur. Ils se trouvent dans `tests/Feature/`. Pour BiblioTech, les Feature Tests vérifient par exemple que la page d'accueil s'affiche avec les statistiques, que la liste des livres est accessible, que la création d'un livre fonctionne avec les bonnes données et échoue avec des données invalides, et que les routes protégées redirigent vers la page de login quand l'utilisateur n'est pas connecté.

### Les assertions : le vocabulaire des tests

Les assertions sont les vérifications qu'on effectue dans un test. Elles constituent le vocabulaire de base que chaque étudiant doit maîtriser.

`assertStatus(200)` vérifie que la réponse HTTP a le code attendu. Le code 200 signifie que tout va bien, 302 signifie une redirection, 403 signifie accès interdit, et 404 signifie page non trouvée.

`assertSee('Livres')` vérifie qu'un texte précis apparaît dans la page HTML retournée. C'est utile pour vérifier que les données s'affichent correctement.

`assertDatabaseHas('livres', ['titre' => 'Laravel pour les nuls'])` vérifie qu'un enregistrement existe dans la table `livres` de la base de données avec le titre indiqué. C'est essentiel pour tester que la création ou la modification a bien persisté les données.

`assertRedirect('/login')` vérifie que la réponse est une redirection vers l'URL indiquée. C'est typique pour tester que les routes protégées redirigent les utilisateurs non connectés.

`actingAs($user)` permet de simuler un utilisateur connecté dans un test. C'est indispensable pour tester les fonctionnalités qui nécessitent une authentification, comme la création de livres ou l'accès à l'interface d'administration.

### Le trait RefreshDatabase

Le trait `RefreshDatabase` est un mécanisme fondamental de Laravel pour les tests. Quand on l'ajoute à une classe de test, Laravel remet la base de données à zéro avant chaque test individuel. Cela garantit que chaque test part d'un état propre et ne dépend pas de l'ordre d'exécution des autres tests. Sans ce trait, un test qui crée un livre pourrait faire échouer un autre test qui compte le nombre de livres, simplement parce qu'il s'exécute après.

### Couverture de code

La couverture de code, ou code coverage, mesure le pourcentage du code source qui est exécuté par au moins un test. L'objectif pour BiblioTech est d'atteindre plus de 70% de couverture. On génère le rapport de couverture avec `php artisan test --coverage`. En pratique, il faut au minimum tester toutes les routes principales (accueil, liste des livres, détail, création, modification, suppression), les cas d'erreur (validation, accès interdit), et les fonctionnalités d'authentification (login, register, logout, protection des routes).

### L'approche TDD

Le Test-Driven Development, ou TDD, est une méthode de développement où l'on écrit le test avant le code. Le cycle est simple : d'abord on écrit un test qui échoue (phase rouge), puis on écrit le minimum de code pour que le test passe (phase verte), et enfin on améliore le code tout en gardant les tests verts (phase refactoring). Cette approche n'est pas obligatoire pour les étudiants mais c'est une bonne pratique professionnelle qui est valorisée lors de l'épreuve E6.

---

## CI/CD avec GitHub Actions : automatiser la qualité

### Le concept d'intégration continue

CI signifie Continuous Integration, l'intégration continue. Le principe est simple : à chaque fois qu'un développeur pousse du code sur GitHub avec un `git push`, un serveur distant exécute automatiquement tous les tests du projet. Si un test échoue, le développeur est alerté immédiatement par un badge rouge sur GitHub. Si tout passe, le badge est vert.

L'intérêt est énorme dans un contexte d'équipe ou même en solo. Sans CI, un développeur peut oublier de lancer les tests avant de pousser son code. Avec CI, c'est automatique et systématique. Impossible de tricher ou d'oublier.

CD signifie Continuous Deployment, le déploiement continu. C'est l'étape suivante : si tous les tests passent, le code est automatiquement déployé en production sans intervention humaine. C'est le niveau le plus avancé de l'automatisation.

### Le fichier workflow GitHub Actions

Le pipeline CI/CD est défini dans un fichier YAML qui se trouve dans `.github/workflows/ci.yml`. Ce fichier décrit précisément les étapes à exécuter sur le serveur de GitHub.

Le workflow se déclenche automatiquement sur chaque `push` et chaque `pull_request`. Les étapes typiques pour un projet Laravel sont : vérifier le code source du repository, installer PHP 8.3 avec les extensions nécessaires (mbstring, xml, pdo_sqlite), installer les dépendances Composer, copier le fichier `.env.example` en `.env`, générer la clé d'application avec `php artisan key:generate`, créer le fichier de base de données SQLite, exécuter les migrations avec `php artisan migrate`, et enfin lancer les tests avec `php artisan test`.

Chaque étape est identifiée par un nom explicite et utilise des actions pré-construites disponibles sur le marketplace GitHub, comme `actions/checkout@v4` pour récupérer le code ou `shivammathur/setup-php@v2` pour installer PHP.

### Visualiser les résultats

On peut voir l'état de toutes les exécutions dans l'onglet "Actions" de GitHub. Chaque exécution montre un badge vert (tout a passé) ou rouge (quelque chose a échoué). En cliquant sur une exécution, on voit le détail de chaque étape avec les logs complets. C'est un outil précieux pour diagnostiquer les problèmes.

---

## SonarCloud : analyser la qualité du code

### Qu'est-ce que SonarCloud

SonarCloud est un service en ligne gratuit pour les projets open-source qui analyse automatiquement la qualité du code source. Contrairement aux tests qui vérifient que le code fonctionne correctement, SonarCloud effectue une analyse statique : il examine le code sans l'exécuter pour détecter des problèmes de qualité, de sécurité et de maintenabilité.

C'est un complément aux outils déjà utilisés dans le pipeline. PHPStan vérifie les erreurs de typage et de logique PHP. Laravel Pint vérifie le style et le formatage du code. Composer Audit détecte les vulnérabilités dans les dépendances. PHPUnit teste le comportement du code. SonarCloud fournit une vue d'ensemble centralisée de tout cela avec des métriques visuelles et un suivi dans le temps. C'est l'outil que le chef de projet ou le client consultera pour évaluer la qualité d'une livraison.

### Les quatre métriques clés

SonarCloud évalue le code selon quatre axes principaux.

Les bugs sont des erreurs dans le code qui vont probablement causer un dysfonctionnement. Par exemple, une condition qui est toujours vraie, ou une variable utilisée avant d'être initialisée.

Les vulnérabilités sont des failles de sécurité potentielles. Par exemple, une injection SQL possible, un mot de passe en clair dans le code, ou un cookie sans attribut HttpOnly.

Les code smells sont du code qui fonctionne mais qui est mal écrit ou difficile à maintenir. Par exemple, une fonction trop longue avec trop de conditions imbriquées, du code dupliqué, ou des variables avec des noms incompréhensibles. Les code smells ne causent pas de bug immédiat mais rendent le code plus fragile et plus coûteux à maintenir dans le temps.

La couverture de tests, ou coverage, est le pourcentage du code qui est exécuté par les tests automatisés. SonarCloud récupère cette information depuis le rapport de couverture généré par PHPUnit.

SonarCloud calcule également la dette technique, qui est le temps estimé pour corriger tous les problèmes détectés. Par exemple, "2 jours de dette technique" signifie qu'il faudrait environ 2 jours de travail pour remettre le code au niveau de qualité attendu.

### La Quality Gate

La Quality Gate est le concept central de SonarCloud. C'est un ensemble de conditions que le code doit respecter pour être considéré comme "de qualité suffisante". C'est comme un contrôle qualité à la sortie de l'usine : soit le produit passe, soit il est renvoyé en atelier.

Par défaut, SonarCloud utilise la Quality Gate "Sonar Way" qui vérifie que le nouveau code n'a aucun nouveau bug, aucune nouvelle vulnérabilité, une couverture du nouveau code supérieure ou égale à 80%, et un taux de duplication du nouveau code inférieur à 3%.

Le badge en haut du tableau de bord SonarCloud affiche clairement si le projet passe (Passed avec un badge vert) ou échoue (Failed avec un badge rouge). Ce badge peut aussi être intégré directement dans le README du projet sur GitHub pour afficher la qualité en permanence.

### Configuration de SonarCloud sur le projet BiblioTech

La mise en place de SonarCloud nécessite plusieurs étapes que les étudiants réalisent pendant le TP.

D'abord, il faut créer un compte SonarCloud en se connectant avec son compte GitHub. SonarCloud est gratuit pour les projets publics. Ensuite, on importe le repository BiblioTech dans SonarCloud, qui crée automatiquement le projet d'analyse.

Il faut ensuite configurer un fichier `sonar-project.properties` à la racine du projet Laravel. Ce fichier définit la clé du projet, le nom affiché, les répertoires de code source à analyser, les fichiers à exclure de l'analyse (comme les dépendances vendor, le dossier node_modules, les fichiers de configuration), et le chemin vers le rapport de couverture de tests.

Un secret `SONAR_TOKEN` doit être ajouté dans les paramètres du repository GitHub, dans la section Secrets and variables puis Actions. Ce token permet à GitHub Actions de communiquer avec SonarCloud de manière sécurisée sans exposer les identifiants dans le code.

Enfin, un nouveau job `sonarcloud` est ajouté dans le fichier workflow GitHub Actions. Ce job s'exécute après le job de tests (grâce à la directive `needs: [test]`). Il installe PHP, les dépendances, prépare l'environnement, lance les tests avec la génération du rapport de couverture, et exécute l'analyse SonarCloud. Un point technique important : le checkout du code doit utiliser `fetch-depth: 0` pour récupérer l'historique Git complet, car SonarCloud en a besoin pour distinguer le nouveau code du code existant.

### Interpréter les résultats et corriger les problèmes

Le tableau de bord SonarCloud affiche un résumé visuel avec le nombre de bugs, de vulnérabilités, de code smells, et le pourcentage de couverture. En cliquant sur chaque métrique, on accède à la liste détaillée des problèmes avec le fichier et la ligne concernés, la sévérité (Blocker, Critical, Major, Minor, Info), le temps estimé de correction, et une explication du problème avec la solution recommandée.

Les exemples de corrections courantes sur BiblioTech incluent la refactorisation de fonctions trop complexes en utilisant le chaînage conditionnel de Query Builder à la place de multiples conditions imbriquées, le remplacement des requêtes SQL concaténées par des requêtes paramétrées ou Eloquent pour éliminer les risques d'injection SQL, et l'extraction de la logique de validation dupliquée entre les méthodes store et update vers un Form Request dédié.

### SonarLint : l'analyse en temps réel dans l'éditeur

SonarLint est une extension gratuite pour VS Code ou PHPStorm qui détecte les problèmes SonarCloud en temps réel pendant que l'étudiant code, avant même de faire un commit. C'est comme avoir un correcteur orthographique mais pour la qualité du code. L'extension peut être connectée au projet SonarCloud pour utiliser les mêmes règles d'analyse.

### Intérêt pour les épreuves BTS SIO

Pour l'épreuve E6, montrer que l'on utilise SonarCloud démontre une démarche professionnelle de qualité logicielle. Les jurys apprécient les candidats qui ne se contentent pas de coder mais qui s'assurent aussi de la qualité de leur production. Il est fortement recommandé d'inclure des captures d'écran du dashboard SonarCloud dans la documentation technique et d'ajouter les badges SonarCloud au README du projet.

Pour l'épreuve E5 et le tableau de synthèse, SonarCloud alimente directement plusieurs compétences du Bloc 1. "Gérer le patrimoine informatique" en exploitant SonarCloud comme référentiel de normes qualité. "Travailler en mode projet" en évaluant les indicateurs de suivi que sont les métriques SonarCloud et en analysant les écarts représentés par la dette technique. "Mettre à disposition un service informatique" en déployant SonarCloud et en réalisant des tests d'intégration via le pipeline CI/CD. "Organiser son développement professionnel" en mettant en place un outil de veille sur la qualité du code et en développant des compétences DevOps.

---

## Configuration pour la production : préparer l'application au monde réel

### Les différences entre développement et production

En développement, la priorité est la facilité de débogage. Le mode debug est activé (`APP_DEBUG=true`), les erreurs s'affichent en détail avec la stack trace complète, et les optimisations sont désactivées pour que chaque modification soit prise en compte immédiatement.

En production, la priorité est la performance et la sécurité. Le mode debug doit être impérativement désactivé (`APP_DEBUG=false`). C'est une règle de sécurité absolue : les messages d'erreur détaillés exposent la structure du code, les chemins de fichiers sur le serveur, les informations de configuration, les variables d'environnement. Ce sont des informations précieuses pour un attaquant. Si un étudiant déploie avec `APP_DEBUG=true`, c'est une faute de sécurité grave.

Il existe aussi un environnement intermédiaire appelé staging ou pré-production. C'est une copie fidèle de l'environnement de production mais sans utilisateurs réels. On y déploie le code avant la production pour vérifier que tout fonctionne dans des conditions réalistes. C'est comme une répétition générale avant la première d'un spectacle.

### Les quatre commandes d'optimisation Laravel

Quatre commandes sont essentielles avant chaque déploiement en production.

`php artisan config:cache` met en cache toute la configuration de l'application. En développement, Laravel lit les fichiers de configuration et le fichier `.env` à chaque requête. En production, cette commande compile tout en un seul fichier PHP, ce qui élimine la lecture du disque et accélère significativement le temps de réponse.

`php artisan route:cache` met en cache les routes. Laravel n'a plus besoin de parser les fichiers de routes à chaque requête, ce qui accélère la résolution des URL, surtout quand l'application a beaucoup de routes.

`php artisan view:cache` pré-compile les vues Blade en PHP pur. Blade n'a plus besoin de convertir les templates à chaque affichage.

`composer install --optimize-autoloader --no-dev` optimise le chargement automatique des classes PHP et supprime toutes les dépendances de développement (comme PHPUnit, les outils de debug, les bibliothèques de test) qui n'ont rien à faire sur un serveur de production.

### HTTPS obligatoire

En production, toutes les communications entre le navigateur de l'utilisateur et le serveur doivent être chiffrées avec HTTPS. Sans HTTPS, les mots de passe, les cookies de session et toutes les données sensibles transitent en clair sur le réseau et peuvent être interceptés. Let's Encrypt fournit des certificats SSL/TLS gratuits et automatiquement renouvelés. C'est devenu un standard incontournable.

### Le fichier .env de production

Le fichier `.env` de production contient les vrais identifiants de base de données, les clés API, les informations de connexion aux services externes. Il ne doit jamais être versionné dans Git (il est dans le `.gitignore`). Chaque serveur a son propre fichier `.env` avec ses propres valeurs. Les différences principales avec le `.env` de développement sont `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` avec le vrai nom de domaine, et les identifiants de la base de données de production.

---

## Le déploiement : mettre l'application en ligne

### Options de déploiement

Plusieurs options sont possibles selon le contexte et le budget.

L'hébergement mutualisé est le plus simple et le moins cher, mais il offre peu de contrôle sur la configuration du serveur. Il convient pour des projets simples.

Le VPS, ou Virtual Private Server, offre plus de contrôle. On dispose d'un serveur virtuel avec un accès root complet. C'est l'option la plus courante pour des applications Laravel en production. On peut installer exactement ce dont on a besoin.

Heroku est un Platform-as-a-Service qui simplifie considérablement le déploiement. Un simple `git push heroku main` déploie l'application. C'est idéal pour les étudiants qui veulent un déploiement rapide sans gérer l'infrastructure.

Le serveur dédié offre un contrôle total mais nécessite des compétences système avancées. C'est rarement justifié pour un projet de formation.

### Le processus de déploiement type

Le déploiement suit un processus standard, qu'il soit manuel ou automatisé.

On clone le repository sur le serveur avec `git clone` ou on met à jour avec `git pull`. On installe les dépendances avec `composer install --optimize-autoloader --no-dev`. On configure le fichier `.env` de production avec les vrais identifiants. On exécute les migrations de base de données avec `php artisan migrate --force` (le flag `--force` est nécessaire en production car Laravel demande confirmation par défaut). On lance les commandes d'optimisation pour la mise en cache. Et on configure le serveur web, que ce soit Nginx ou Apache, pour pointer vers le dossier `public/` de Laravel, qui est le seul dossier accessible depuis le web.

### La stratégie de rollback

Un plan de rollback est essentiel. Si le déploiement casse l'application, on doit pouvoir revenir à la version précédente rapidement. Git permet de revenir à n'importe quel commit antérieur avec `git checkout`. Les tags Git sont utilisés pour marquer les versions stables : v1.0, v1.1, v2.0. Avant chaque déploiement, on crée un tag sur le commit actuel pour pouvoir y revenir facilement.

Les stratégies de déploiement avancées incluent le déploiement Blue-Green, où deux versions de l'application tournent en parallèle et on bascule le trafic de l'une à l'autre, et le déploiement Canary, où la nouvelle version est d'abord déployée pour un petit pourcentage d'utilisateurs avant de l'étendre à tous. Ces stratégies sont présentées comme des extensions optionnelles pour les étudiants avancés.

---

## Le monitoring : surveiller l'application en production

### Pourquoi surveiller

Une application en production peut rencontrer des erreurs que personne ne signale. Les utilisateurs qui rencontrent un bug quittent souvent le site sans le dire. Le monitoring permet de détecter et corriger les problèmes avant qu'ils n'impactent trop d'utilisateurs. C'est comme les capteurs dans un avion : le pilote est alerté d'un problème avant qu'il ne devienne critique.

### Les logs Laravel

Laravel enregistre automatiquement les erreurs et les événements dans des fichiers de log situés dans `storage/logs/laravel.log`. On peut consulter les logs en temps réel avec `tail -f storage/logs/laravel.log`. Laravel supporte différents canaux de logs qu'on peut configurer : un canal fichier pour le stockage local, un canal base de données, un canal Slack pour recevoir les erreurs critiques directement dans un canal de discussion, ou un canal vers un service externe.

### Sentry pour le suivi des erreurs

Sentry est un service d'error tracking qui capture automatiquement les exceptions en production. Quand une erreur se produit, Sentry l'enregistre avec le contexte complet : la stack trace, les données de la requête, l'utilisateur connecté, le navigateur utilisé. Sentry regroupe les erreurs similaires, compte le nombre d'occurrences, et envoie des alertes par email ou Slack. L'intégration avec Laravel se fait en quelques lignes : on installe le package `sentry/sentry-laravel`, on ajoute le DSN dans le `.env`, et Sentry capture automatiquement toutes les exceptions non gérées.

### Le Health Check

Un Health Check est une route dédiée de l'application, typiquement `/health/deep`, qui vérifie que tous les composants fonctionnent correctement. Cette route teste la connexion à la base de données, l'accès au cache, les permissions d'écriture sur le disque de stockage, et retourne un JSON avec le statut de chaque composant. Les services de monitoring externes appellent cette URL à intervalles réguliers (toutes les minutes par exemple) et alertent l'équipe si l'application ne répond plus ou si un composant est en erreur.

---

## Le pipeline complet de la séance 5

Le pipeline complet représente le cycle de vie professionnel d'une application. Le développeur code en local sur sa machine. Il écrit des tests pour vérifier que son code fonctionne. Il pousse son code sur GitHub. GitHub Actions exécute automatiquement les tests. Si les tests passent, SonarCloud analyse la qualité du code et vérifie que la Quality Gate est respectée. Si tout est vert, le code peut être déployé sur le serveur de staging pour une vérification manuelle. Une fois validé en staging, le code est déployé en production. Le monitoring surveille en continu que l'application fonctionne correctement en production.

---

## Les livrables attendus en fin de séance

À la fin de cette séance, chaque étudiant doit avoir produit une suite de tests avec un objectif de 50 tests ou plus, un pipeline GitHub Actions configuré et fonctionnel avec un badge vert, SonarCloud configuré avec une Quality Gate qui passe, l'application déployée et accessible en ligne, le monitoring et les alertes en place, une procédure de rollback testée, et une documentation complète du processus.

---

## L'évaluation de la séance 5

### Questions théoriques attendues

L'évaluation théorique porte sur quatre questions fondamentales. Expliquer la différence entre un Unit Test et un Feature Test : le Unit Test teste une classe isolée tandis que le Feature Test teste une route complète. Expliquer ce qu'est un pipeline CI/CD et à quoi il sert : le CI exécute les tests automatiquement à chaque push, le CD déploie automatiquement si les tests passent. Expliquer pourquoi il faut désactiver APP_DEBUG en production : pour éviter d'exposer la structure du code et les informations sensibles aux visiteurs et aux attaquants. Lister les commandes d'optimisation Laravel pour la production : config:cache, route:cache, view:cache, et l'installation Composer optimisée.

### Grille de notation

Les tests unitaires fonctionnels avec une couverture supérieure à 70% comptent pour 3 points. Les tests Feature complets couvrant les routes principales comptent pour 3 points. Le pipeline CI/CD configuré avec GitHub Actions compte pour 2 points. Le déploiement en production avec une application accessible en ligne compte pour 3 points. La configuration de sécurité avec APP_DEBUG désactivé et HTTPS en place compte pour 2 points. Le monitoring et les logs accessibles comptent pour 2 points. Les extensions réalisées en bonus comptent pour 1 point. Le total est sur 16. Un score de 14 à 16 est considéré excellent, de 12 à 13 bon, de 10 à 11 satisfaisant, et en dessous de 10 à revoir.

### Auto-évaluation par niveaux

Le niveau 1, considéré comme essentiel, vérifie que l'étudiant sait créer un test avec `php artisan make:test`, tester une route, vérifier un status HTTP, configurer les variables d'environnement pour la production, et lancer les tests.

Le niveau 2, considéré comme important, vérifie que l'étudiant sait configurer GitHub Actions, écrire des tests avec Factory et Seeder, tester l'authentification avec `actingAs()`, vérifier la couverture de code, configurer les caches, et déployer sur un serveur.

Le niveau 3, considéré comme bonus, vérifie les compétences avancées comme l'intégration de Sentry, la configuration des logs par canal, la mise en place de HTTPS avec Let's Encrypt, la création d'un processus de rollback, et le monitoring des performances.

---

## Extensions possibles pour les étudiants avancés

Cinq extensions sont proposées pour aller au-delà du programme de base.

La première extension porte sur les tests End-to-End avec Laravel Dusk, qui permettent de tester l'application dans un vrai navigateur, en simulant les clics et les saisies d'un utilisateur réel.

La deuxième extension porte sur la containerisation avec Docker, qui permet de packager l'application et toutes ses dépendances dans un container portable et reproductible.

La troisième extension porte sur le déploiement Blue-Green, une stratégie avancée qui permet de déployer sans interruption de service.

La quatrième extension porte sur le monitoring de performance avec des outils comme New Relic ou DataDog, qui mesurent les temps de réponse et identifient les goulots d'étranglement.

La cinquième extension porte sur les sauvegardes automatisées de la base de données en production.

---

## Les erreurs courantes à éviter

Plusieurs erreurs reviennent fréquemment chez les étudiants lors de cette séance.

Oublier de lancer les tests avant de déployer. C'est exactement le problème que le pipeline CI/CD résout : il automatise ce que l'humain oublie.

Ne pas créer le fichier de base de données SQLite dans le pipeline CI. Le fichier `database.sqlite` n'existe pas par défaut, il faut le créer avec `touch database/database.sqlite` avant d'exécuter les migrations.

Oublier de générer la clé d'application. Sans `php artisan key:generate`, Laravel ne peut pas déchiffrer les cookies et les sessions, ce qui provoque des erreurs mystérieuses.

Laisser `APP_DEBUG=true` en production. C'est la faute de sécurité la plus grave et la plus courante.

Ne pas versionner le fichier `.env` avec les vrais secrets. C'est paradoxal mais essentiel : le `.env` contient des informations sensibles qui ne doivent jamais apparaître dans l'historique Git.

Laisser les permissions incorrectes sur le dossier `storage`. Laravel doit pouvoir écrire dans ce dossier pour les logs, les sessions et le cache.

---

## Compétences BTS SIO mobilisées par la séance 5

### Bloc 1 — Support et mise à disposition de services informatiques (Épreuve E5)

"Gérer le patrimoine informatique" se traduit par l'exploitation de SonarCloud comme référentiel de normes de qualité et la vérification du respect des règles d'utilisation des ressources numériques.

"Travailler en mode projet" se traduit par l'évaluation des indicateurs de suivi grâce aux métriques SonarCloud et l'analyse des écarts représentés par la dette technique.

"Mettre à disposition un service informatique" se traduit par le déploiement de SonarCloud, la réalisation des tests d'intégration via le pipeline CI/CD, et la mise en production de l'application.

"Organiser son développement professionnel" se traduit par la mise en place d'un outil de veille sur la qualité du code et le développement de compétences DevOps.

### Bloc 2 — Conception et développement d'applications SLAM (Épreuve E6)

"Concevoir et développer une solution applicative" se traduit par l'utilisation de l'analyse statique pour améliorer la conception et l'écriture de tests automatisés.

"Assurer la maintenance corrective ou évolutive" se traduit par l'identification et la correction des bugs, des vulnérabilités et des code smells détectés par SonarCloud.

---

*Document généré pour utilisation avec NotebookLM — Séance 5 Production & Déploiement — SP Laravel BiblioTech — BTS SIO SLAM Session 2026*
