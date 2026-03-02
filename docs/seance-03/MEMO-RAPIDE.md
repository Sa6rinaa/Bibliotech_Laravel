# 💡 Mémo Rapide - Séance 03# 💡 Mémo Rapide - Séance 03



## 🚀 Démarrage Express## 🚀 Démarrage Express



### Je débute → Parcours Standard (2h30)### Je débute → Parcours Standard (2h30)

```bash```bash

1. Lire 01-CONCEPTS (20 min)1. Lire 01-CONCEPTS (20 min)

2. Lire 02-GLOSSAIRE (15 min)2. Lire 02-GLOSSAIRE (15 min)

3. Faire 03-DECOUVERTE (30 min)3. Faire 03-DECOUVERTE (30 min)

4. Faire 04-TP-PRATIQUE-CRUD (90 min)4. Faire 04-TP-PRATIQUE-CRUD (90 min)

5. Faire 06-EVALUATION (25 min)5. Faire 06-EVALUATION (25 min)

``````



### Je connais les bases → Parcours Complet (3h)### Je connais les bases → Parcours Complet (3h)

```bash```bash

1. Survoler 01-02 (10 min)1. Survoler 01-02 (10 min)

2. Faire 03-DECOUVERTE (20 min)2. Faire 03-DECOUVERTE (20 min)

3. Faire 04-TP-PRATIQUE-CRUD (60 min)3. Faire 04-TP-PRATIQUE-CRUD (60 min)

4. Faire 05-TP-PRATIQUE-EXERCICES (90 min)4. Faire 05-TP-PRATIQUE-EXERCICES (90 min)

5. Faire 06-EVALUATION (20 min)5. Faire 06-EVALUATION (20 min)

``````



### Je suis expert → Parcours Avancé (3h+)### Je suis expert → Parcours Avancé (3h+)

```bash```bash

Parcours Complet + optimisations personnaliséesParcours Complet + optimisations personnalisées

``````



------



## 🔍 Quelle est la Différence ?## 🔍 Quelle est la Différence ?



### **03-DECOUVERTE** vs **04-TP-PRATIQUE**### **03-DECOUVERTE** vs **04-TP-PRATIQUE**

- **DECOUVERTE** = 👀 Observer le code existant (explorer sans créer)- **DECOUVERTE** = 👀 Observer le code existant (explorer sans créer)

- **TP-PRATIQUE** = ✋ Créer du code guidé (suivre les instructions)- **TP-PRATIQUE** = ✋ Créer du code guidé (suivre les instructions)



### **04-TP-PRATIQUE** vs **05-EXERCICES**### **04-TP-PRATIQUE** vs **05-EXERCICES**

- **TP-PRATIQUE** = 🎯 1 objectif avec code fourni (guidé)- **TP-PRATIQUE** = 🎯 1 objectif avec code fourni (guidé)

- **EXERCICES** = 🏆 5 modules autonomes avec indices (défi)- **EXERCICES** = 🏆 5 modules autonomes avec indices (défi)



------



## ⚡ Actions Rapides## ⚡ Actions Rapides



### **Créer rapidement un contrôleur CRUD**### **Créer rapidement un contrôleur CRUD**

```bash```bash

php artisan make:controller LivreController --resourcephp artisan make:controller LivreController --resource

``````



### **Créer toutes les vues en une fois**### **Créer toutes les vues en une fois**

```bash```bash

# Dans resources/views/livres/# Dans resources/views/livres/

touch index.blade.php create.blade.php edit.blade.php show.blade.phptouch index.blade.php create.blade.php edit.blade.php show.blade.php

``````



### **Tester rapidement les routes**### **Tester rapidement les routes**

```bash```bash

php artisan route:list --name=livresphp artisan route:list --name=livres

``````



------



## 🎯 Objectifs par Niveau## 🎯 Objectifs par Niveau



### **Niveau Débutant** (obligatoire)### **Niveau Débutant** (obligatoire)

- ✅ Formulaire d'ajout de livre fonctionnel- ✅ Formulaire d'ajout de livre fonctionnel

- ✅ Liste des livres avec lien modification- ✅ Liste des livres avec lien modification

- ✅ Suppression d'un livre- ✅ Suppression d'un livre



### **Niveau Confirmé** (recommandé)### **Niveau Confirmé** (recommandé)

- ✅ Validation des champs obligatoires- ✅ Validation des champs obligatoires

- ✅ Messages de succès/erreur- ✅ Messages de succès/erreur

- ✅ Préremplissage du formulaire de modification- ✅ Préremplissage du formulaire de modification



### **Niveau Expert** (bonus)### **Niveau Expert** (bonus)

- ✅ Upload d'image de couverture- ✅ Upload d'image de couverture

- ✅ Gestion des relations (auteurs multiples)- ✅ Gestion des relations (auteurs multiples)

- ✅ Recherche et filtres- ✅ Recherche et filtres



------



## 🔧 Commandes Utiles## 🔧 Commandes Utiles



### **Artisan (développement)**### **Artisan (développement)**

```bash```bash

php artisan serve              # Démarrer le serveurphp artisan serve              # Démarrer le serveur

php artisan make:controller    # Créer un contrôleurphp artisan make:controller    # Créer un contrôleur

php artisan route:list         # Lister les routesphp artisan route:list         # Lister les routes

php artisan tinker             # Console interactivephp artisan tinker             # Console interactive

``````



### **Git (versioning)**### **Git (versioning)**

```bash```bash

git add .                      # Ajouter les modificationsgit add .                      # Ajouter les modifications

git commit -m "CRUD livres"    # Valider les changementsgit commit -m "CRUD livres"    # Valider les changements

git push                       # Envoyer sur GitHubgit push                       # Envoyer sur GitHub

``````



------



## 📋 Checklist Séance 03## 📋 Checklist Séance 03



### **Avant de Commencer**### **Avant de Commencer**

- [ ] Séance 2 terminée (base de données)- [ ] Séance 2 terminée (base de données)

- [ ] Application fonctionne (`php artisan serve`)- [ ] Application fonctionne (`php artisan serve`)

- [ ] Modèles `Livre` et `Categorie` présents- [ ] Modèles `Livre` et `Categorie` présents



### **Pendant la Séance**### **Pendant la Séance**

- [ ] Contrôleur `LivreController` créé- [ ] Contrôleur `LivreController` créé

- [ ] Routes resource configurées- [ ] Routes resource configurées

- [ ] Formulaires HTML fonctionnels- [ ] Formulaires HTML fonctionnels

- [ ] Validation des données active- [ ] Validation des données active



### **À la Fin**### **À la Fin**

- [ ] CRUD complet opérationnel- [ ] CRUD complet opérationnel

- [ ] Messages flash affichés- [ ] Messages flash affichés

- [ ] Tests de validation passent- [ ] Tests de validation passent

- [ ] Code committé sur Git- [ ] Code committé sur Git



------



**🎯 Focus de la séance : Du simple affichage aux formulaires interactifs !****🎯 Focus de la séance : Du simple affichage aux formulaires interactifs !**