# ✅ Évaluation des Compétences - Séance 03

**Test pratique : Contrôleurs & Vues Laravel**

---

## 📋 Informations Générales

### **🎯 Objectif de l'Évaluation**
Valider les compétences acquises en développement de contrôleurs resource et création de vues Blade avancées.

### **⏱️ Modalités**
- **Durée :** 50 minutes ⏰ **AJUSTÉ**
- **Type :** Évaluation pratique individuelle
- **Support :** Documentation Laravel + Fiche mémo autorisées
- **Outils :** VS Code, navigateur, terminal
- **💡 Templates Blade :** Vous pouvez utiliser `resources/views/templates/` comme référence

### **📊 Barème**
- **Total :** 20 points
- **Seuil de validation :** 12/20
- **Excellent :** 16/20 et plus

### **⚡ Simplifications pour 50 minutes**
- **Vues requises :** 2 vues seulement (INDEX + CREATE) au lieu de 4
- **Validation :** Règles de base uniquement
- **Relations :** Affichage simple sans optimisation avancée

---

## 🎯 Énoncé du Test

### **📖 Contexte**
Vous devez créer un système de gestion des **auteurs** pour l'application BiblioTech. Ce système doit permettre de gérer les informations des auteurs et leurs relations avec les livres.

### **📋 Cahier des Charges**

#### **Fonctionnalités Requises :**
1. **CRUD Complet** : Créer, lire, modifier, supprimer des auteurs
2. **Interface Utilisateur** : Vues Blade avec design Bootstrap
3. **Validation** : Validation des données côté serveur
4. **Relations** : Affichage des livres associés à chaque auteur
5. **Messages Flash** : Feedback utilisateur après chaque action

#### **Données Auteur :**
- **Nom complet** (obligatoire, max 255 caractères)
- **Date de naissance** (obligatoire, format date)
- **Nationalité** (obligatoire, max 100 caractères)
- **Biographie** (optionnel, texte long)
- **Site web** (optionnel, URL valide)
- **Actif** (boolean, défaut true)

> **📝 Note pédagogique :** Cette évaluation prépare la séance 4 en introduisant le concept de modèle Auteur distinct. Actuellement, les livres utilisent un champ `auteur` string que nous transformerons en relation en séance 4.

---

## 🏗️ Partie 1 : Structure et Modèle (4 points)

### **📝 Exercice 1.1 : Migration et Modèle (2 points)**

**Créer la migration pour la table `auteurs` :**

```bash
# Commande à exécuter
php artisan make:migration create_auteurs_table
```

**Spécifications de la table :**
- `id` : Clé primaire auto-incrémentée
- `nom_complet` : VARCHAR(255), NOT NULL
- `date_naissance` : DATE, NOT NULL
- `nationalite` : VARCHAR(100), NOT NULL
- `biographie` : TEXT, NULLABLE
- `site_web` : VARCHAR(255), NULLABLE
- `actif` : BOOLEAN, DEFAULT TRUE
- `created_at` et `updated_at` : Timestamps Laravel

**Créer le modèle Eloquent :**

```bash
# Commande à exécuter
php artisan make:model Auteur
```

### **📝 Exercice 1.2 : Relations et Configuration (2 points)**

**Configurer le modèle `Auteur` avec :**
- Propriété `$fillable` appropriée
- Casting des dates et booléens
- Relation `hasMany` avec le modèle `Livre`

**Modifier le modèle `Livre` pour ajouter :**
- Relation `belongsTo` avec le modèle `Auteur`
- Migration pour ajouter `auteur_id` à la table `livres`

---

## 🎛️ Partie 2 : Contrôleur Resource (6 points)

### **📝 Exercice 2.1 : Génération et Configuration (2 points)**

**Créer le contrôleur resource :**

```bash
# Commande à exécuter
php artisan make:controller AuteurController --resource
```

**Configurer les routes dans `routes/web.php` :**
- Route resource complète pour les auteurs
- Nommage approprié des routes

### **📝 Exercice 2.2 : Méthodes CRUD (4 points)**

**Implémenter toutes les méthodes du contrôleur :**

#### **Méthode `index()` (1 point)**
- Récupérer tous les auteurs avec pagination (10 par page)
- Trier par nom complet
- Compter le nombre de livres par auteur

#### **Méthode `create()` (0.5 point)**
- Afficher le formulaire de création
- Passer les données nécessaires à la vue

#### **Méthode `store()` (1 point)**
- Valider les données reçues
- Créer l'auteur en base
- Rediriger avec message de succès

#### **Méthode `show()` (0.5 point)**
- Afficher un auteur avec ses livres
- Utiliser Route Model Binding

#### **Méthode `edit()` (0.5 point)**
- Afficher le formulaire de modification pré-rempli

#### **Méthode `update()` (1 point)**
- Valider les données
- Mettre à jour l'auteur
- Rediriger avec message de succès

#### **Méthode `destroy()` (0.5 point)**
- Supprimer l'auteur
- Vérifier qu'il n'a pas de livres associés
- Rediriger avec message de succès

---

## 🎨 Partie 3 : Vues Blade (6 points) ⚡ SIMPLIFIÉ

> **💡 Astuce** : Vous pouvez utiliser les templates fournis dans `resources/views/templates/` comme point de départ !

### **📝 Exercice 3.1 : Vue Index (3 points)**

**Créer `resources/views/auteurs/index.blade.php` :**
- Tableau responsive avec Bootstrap
- Colonnes : Nom, Nationalité, Date naissance, Statut, Actions
- Pagination avec liens
- Bouton "Ajouter un auteur"
- Badge pour le statut actif/inactif (vert/gris)

**� Conseil :** Utilisez `resources/views/templates/index.blade.php` comme base et adaptez-le.

### **📝 Exercice 3.2 : Formulaire Create (3 points)**

**Créer `resources/views/auteurs/create.blade.php` :**
- Formulaire avec méthode POST vers route `auteurs.store`
- Tous les champs avec labels appropriés
- Validation visuelle (classes Bootstrap pour erreurs)
- Affichage des erreurs avec `@error`
- Conservation des valeurs saisies (`old()`)
- Boutons "Enregistrer" et "Annuler"

**💡 Conseil :** Utilisez `resources/views/templates/create.blade.php` comme base et adaptez-le.

**⚠️ Simplification :** Les vues SHOW et EDIT ne sont **pas demandées** pour gagner du temps.

---

## ✅ Partie 4 : Validation et UX (4 points)

### **📝 Exercice 4.1 : Validation (2 points)**

**Règles de validation pour création/modification :**
- `nom_complet` : obligatoire, string, max 255 caractères
- `date_naissance` : obligatoire, date, antérieure à aujourd'hui
- `nationalite` : obligatoire, string, max 100 caractères
- `biographie` : optionnel, string, max 5000 caractères
- `site_web` : optionnel, URL valide
- `actif` : boolean

**Messages d'erreur personnalisés en français**

### **📝 Exercice 4.2 : Messages Flash et Navigation (2 points)**

**Implémenter :**
- Messages de succès après création/modification/suppression
- Messages d'erreur appropriés
- Navigation cohérente entre les vues
- Breadcrumb ou fil d'Ariane

---

## 🧪 Tests de Validation

### **✅ Checklist de Fonctionnement**

**Structure :**
- [ ] Migration créée et exécutée sans erreur
- [ ] Modèle Auteur avec relations configurées
- [ ] Routes resource définies

**Contrôleur :**
- [ ] Toutes les méthodes CRUD implémentées
- [ ] Validation fonctionnelle
- [ ] Redirections appropriées

**Vues :**
- [ ] Vue index avec tableau et pagination ✅ OBLIGATOIRE
- [ ] Formulaire create fonctionnel ✅ OBLIGATOIRE
- [ ] Vue show (optionnel - bonus)
- [ ] Formulaire edit (optionnel - bonus)
- [ ] Design Bootstrap cohérent

**UX :**
- [ ] Messages flash affichés
- [ ] Validation côté client/serveur
- [ ] Navigation fluide
- [ ] Interface responsive

---

## 📊 Grille d'Évaluation Détaillée

### **Partie 1 : Structure (4 points)**
| Critère | Excellent (2) | Bien (1.5) | Moyen (1) | Insuffisant (0.5) |
|---------|---------------|------------|-----------|-------------------|
| **Migration** | Complete et correcte | Mineurs défauts | Quelques erreurs | Non fonctionnelle |
| **Modèle** | Relations parfaites | Relations ok | Relations basiques | Modèle incomplet |

### **Partie 2 : Contrôleur (6 points)**
| Critère | Excellent | Bien | Moyen | Insuffisant |
|---------|-----------|------|-------|-------------|
| **CRUD Complet** | 7 méthodes parfaites | 5-6 méthodes ok | 3-4 méthodes | < 3 méthodes |
| **Validation** | Robuste et complète | Bonne validation | Validation basique | Peu/pas validé |
| **Code Quality** | Clean et optimisé | Bien structuré | Code acceptable | Code problématique |

### **Partie 3 : Vues (6 points)**
| Critère | Excellent | Bien | Moyen | Insuffisant |
|---------|-----------|------|-------|-------------|
| **Completude** | Toutes vues parfaites | 3/4 vues complètes | 2/4 vues | 1 vue seulement |
| **Design** | Bootstrap professionnel | Design cohérent | Design basique | Design négligé |
| **UX** | Interface intuitive | Bonne utilisabilité | UX acceptable | UX problématique |

### **Partie 4 : Validation/UX (4 points)**
| Critère | Excellent | Bien | Moyen | Insuffisant |
|---------|-----------|------|-------|-------------|
| **Validation** | Complète et robuste | Bonne validation | Validation ok | Validation faible |
| **Messages** | Flash parfaits | Messages clairs | Messages basiques | Peu de feedback |

---

## 🎯 Conseils pour Réussir

### **⏰ Gestion du Temps (45 min)**
- **0-10 min :** Structure (migration, modèle, routes)
- **10-25 min :** Contrôleur CRUD complet
- **25-40 min :** Vues et formulaires
- **40-45 min :** Tests et finitions

### **🔧 Stratégie Recommandée**
1. **Commencer par la structure** (modèle, migration)
2. **Tester chaque méthode** du contrôleur au fur et à mesure
3. **Créer les vues une par une** en testant l'affichage
4. **Finaliser la validation** et les messages

### **💡 Points d'Attention**
- **Respecter les conventions** Laravel (nommage, structure)
- **Tester régulièrement** dans le navigateur
- **Vérifier la validation** avec des données incorrectes
- **S'assurer que les relations** fonctionnent

---

## 📝 Modalités de Rendu

### **💾 Livraison**
- **Fichiers à rendre :** Tous les fichiers créés/modifiés
- **Format :** Code source + captures d'écran des pages
- **Délai :** Fin de la séance (45 minutes)

### **🧪 Démonstration**
- **Test en direct** de toutes les fonctionnalités
- **Explication** des choix techniques
- **Questions-réponses** sur l'implémentation

---

## 🏆 Critères d'Excellence

### **🌟 Pour obtenir 16+ points :**
- Code parfaitement structuré et documenté
- Interface utilisateur soignée et intuitive
- Validation robuste avec messages clairs
- Gestion d'erreurs appropriée
- Respect total des conventions Laravel
- Fonctionnalités bonus (recherche, tri, etc.)

### **✅ Pour valider (12+ points) :**
- CRUD fonctionnel et complet
- Vues correctement implémentées
- Validation de base fonctionnelle
- Interface utilisable et claire
- Code propre et organisé

🍀 **Bonne chance !** Vous avez toutes les compétences nécessaires pour réussir cette évaluation.