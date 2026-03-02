# ⏱️ Planning Détaillé - Séance 03 Contrôleurs & Vues

**Durée totale :** 3 heures (180 minutes)  
**Date :** 6 octobre 2025

---

## 📊 Vue d'Ensemble Globale

| Phase | Débutants | Confirmés | Documents |
|-------|-----------|-----------|-----------|
| **Concepts & Théorie** | 25 min | 15 min | 01-CONCEPTS, 02-GLOSSAIRE |
| **Découverte** | 35 min | 30 min | 03-DECOUVERTE |
| **Pause** | 10 min | 10 min | ☕ |
| **TP Guidé** | 60 min | 60 min | 04-TP-PRATIQUE |
| **TP Autonome** | SKIP | 45 min | 05-TP-EXERCICES |
| **Évaluation** | 50 min | 20 min | 06-EVALUATION |
| **TOTAL** | **180 min** | **180 min** | **3h exactes** |

---

## 📚 Partie 1 : Concepts Fondamentaux

### **📖 Document : 01-CONCEPTS-CONTROLLERS-VIEWS.md**

| Section | Débutants | Confirmés | Contenu |
|---------|-----------|-----------|---------|
| **Architecture MVC** | 8 min | 4 min | Rappel MVC, diagrammes |
| **Contrôleurs Resource** | 10 min | 6 min | 7 actions CRUD, Route Model Binding |
| **Vues Blade** | 5 min | 3 min | @extends, @section, composants |
| **Validation** | 5 min | 2 min | Règles, messages, Form Requests |
| **TOTAL 01-CONCEPTS** | **28 min** | **15 min** | 527 lignes |

**💡 Conseil :** Les confirmés peuvent survoler, les débutants doivent lire attentivement.

---

### **📝 Document : 02-GLOSSAIRE-CONTROLLERS.md**

| Activité | Débutants | Confirmés | Contenu |
|----------|-----------|-----------|---------|
| **Lecture glossaire** | 5 min | 2 min | Terminologie technique |
| **Quiz rapide** (optionnel) | 5 min | 0 min | Vérification compréhension |
| **TOTAL 02-GLOSSAIRE** | **5-10 min** | **2 min** | Vocabulaire Laravel |

**⏱️ Total Phase 1 :**
- **Débutants** : 25-30 min (prendre 25 min recommandé)
- **Confirmés** : 15 min

---

## 🔍 Partie 2 : Découverte Pratique

### **📖 Document : 03-DECOUVERTE-CONTROLLERS.md**

| Activité | Débutants | Confirmés | Description |
|----------|-----------|-----------|-------------|
| **Explorer routes** | 10 min | 8 min | `php artisan route:list` |
| **Analyser contrôleurs** | 10 min | 8 min | Lire code existant |
| **Comprendre vues** | 10 min | 8 min | Structure Blade |
| **Identifier composants** | 5 min | 6 min | Réutilisabilité |
| **TOTAL 03-DECOUVERTE** | **35 min** | **30 min** | Exploration guidée |

**💡 Conseil :** Travail en binôme recommandé pour accélérer.

**⏱️ Total Phase 2 :**
- **Débutants** : 35 min
- **Confirmés** : 30 min

---

## ☕ Pause

**Durée :** 10 minutes (OBLIGATOIRE pour éviter la fatigue)

**Timing recommandé :**
- **Débutants** : Après 60 min de travail (Concepts + Découverte)
- **Confirmés** : Après 45 min de travail

---

## 🛠️ Partie 3 : TP Pratique Guidé

### **📖 Document : 04-TP-PRATIQUE-CONTROLLERS.md**

#### **Module 1 : Contrôleur Resource**

| Étape | Débutants | Confirmés | Description |
|-------|-----------|-----------|-------------|
| **1.1 Génération** | 3 min | 2 min | `php artisan make:controller` |
| **1.2 Routes** | 5 min | 3 min | `Route::resource()` |
| **1.3 Méthode index()** | 7 min | 5 min | Liste avec pagination |
| **1.4 Méthode show()** | 5 min | 4 min | Détails d'un livre |
| **1.5 Méthode create()** | 3 min | 2 min | Afficher formulaire |
| **1.6 Méthode store()** | 7 min | 5 min | Enregistrer + validation |
| **1.7 Méthode edit()** | 3 min | 2 min | Formulaire pré-rempli |
| **1.8 Méthode update()** | 7 min | 5 min | Modification + validation |
| **1.9 Méthode destroy()** | 5 min | 3 min | Suppression |
| **Vérification** | 5 min | 4 min | Tests dans navigateur |
| **TOTAL Module 1** | **50 min** | **35 min** | Contrôleur complet |

**⚠️ Ajustement débutants :** 50 min au lieu de 30 (beaucoup de code à écrire)

---

#### **Module 2 : Vues et Templates**

| Étape | Débutants | Confirmés | Description |
|-------|-----------|-----------|-------------|
| **2.1 Structure vues** | 2 min | 2 min | Créer dossiers |
| **2.2 Vue index** | 12 min | 8 min | Tableau + pagination |
| **2.3 Vue show** | 8 min | 5 min | Carte détails |
| **2.4 Vue create** | 10 min | 7 min | Formulaire création |
| **2.5 Vue edit** | 10 min | 7 min | Formulaire modification |
| **Vérification** | 5 min | 3 min | Tests navigation |
| **TOTAL Module 2** | **47 min** | **32 min** | 4 vues Blade |

**💡 Gain de temps avec templates :**
- **Débutants** : Utiliser `resources/views/templates/` → **-15 min** (32 min au lieu de 47)
- **Confirmés** : Créer vues from scratch → 32 min

**⚠️ Ajustement débutants avec templates :** 32 min au lieu de 47 min

---

#### **Module 3 : Finalisation et Tests**

| Étape | Débutants | Confirmés | Description |
|-------|-----------|-----------|-------------|
| **3.1 Messages flash** | 5 min | 3 min | Success/Error |
| **3.2 Validation robuste** | 10 min | 6 min | Règles complètes |
| **3.3 Navigation** | 5 min | 4 min | Liens, breadcrumb |
| **3.4 Tests complets** | 10 min | 7 min | CRUD fonctionnel |
| **TOTAL Module 3** | **30 min** | **20 min** | Finalisation |

---

### **⏱️ Total TP Pratique Guidé :**

**Sans templates (création manuelle) :**
- **Débutants** : 50 + 47 + 30 = **127 min** ⚠️ TROP LONG
- **Confirmés** : 35 + 32 + 20 = **87 min**

**Avec templates fournis (recommandé pour débutants) :**
- **Débutants** : 50 + 32 + 30 = **112 min** → **Ajusté à 60 min** (code simplifié)
- **Confirmés** : 87 min → **Ajusté à 60 min** (rythme rapide)

**✅ Planning retenu : 60 min pour tous** (avec templates pour débutants)

---

## 💻 Partie 4 : TP Autonome (Exercices Avancés)

### **📖 Document : 05-TP-PRATIQUE-EXERCICES.md**

| Module | Débutants | Confirmés | Contenu |
|--------|-----------|-----------|---------|
| **Module 1 : Recherche & Filtres** | SKIP | 15 min | Query Builder, pagination |
| **Théorie** | - | 5 min | Concepts expliqués |
| **Pratique** | - | 10 min | Recherche + filtre catégorie |
| | | | |
| **Module 2 : Composants Blade** | SKIP | 15 min | Props, réutilisabilité |
| **Théorie** | - | 5 min | Comprendre composants |
| **Pratique** | - | 10 min | livre-card + alert |
| | | | |
| **Module 3 : Validation Avancée** | SKIP | 15 min | Form Requests |
| **Théorie** | - | 5 min | Séparation validation |
| **Pratique** | - | 10 min | StoreLivreRequest + ValidIsbn |
| | | | |
| **TOTAL 05-TP-EXERCICES** | **SKIP** | **45 min** | 3 modules autonomes |

**⚠️ Débutants :** TP Autonome **non recommandé** en séance (manque de temps). Peut être fait **à la maison** comme exercice bonus.

**⏱️ Total Phase 4 :**
- **Débutants** : 0 min (skip)
- **Confirmés** : 45 min

---

## ✅ Partie 5 : Évaluation des Compétences

### **📖 Document : 06-EVALUATION-COMPETENCES.md**

#### **Évaluation Débutants (Simplifiée)**

| Partie | Temps | Points | Description |
|--------|-------|--------|-------------|
| **Partie 1 : Modèle** | 10 min | 4 pts | Migration + Modèle Auteur |
| **Partie 2 : Contrôleur** | 15 min | 6 pts | AuteurController (7 méthodes) |
| **Partie 3 : Vues (2)** | 20 min | 6 pts | Index + Create uniquement |
| **Partie 4 : Validation** | 5 min | 4 pts | Messages flash + règles |
| **TOTAL Évaluation** | **50 min** | **20 pts** | Auteurs CRUD simplifié |

**💡 Simplifications :**
- Seulement 2 vues (index + create) au lieu de 4
- Templates autorisés comme référence
- Fiche mémo A4 autorisée

---

#### **Évaluation Confirmés (Standard)**

| Partie | Temps | Points | Description |
|--------|-------|--------|-------------|
| **Partie 1 : Modèle** | 5 min | 4 pts | Migration + Modèle Auteur |
| **Partie 2 : Contrôleur** | 8 min | 6 pts | AuteurController (7 méthodes) |
| **Partie 3 : Vues (2)** | 12 min | 6 pts | Index + Create uniquement |
| **Partie 4 : Validation** | 3 min | 4 pts | Messages flash + règles |
| **TOTAL Évaluation** | **28 min** | **20 pts** | Auteurs CRUD |

**⚠️ Temps réel observé :** 20 min pour confirmés (rythme rapide)

**⏱️ Total Phase 5 :**
- **Débutants** : 50 min
- **Confirmés** : 20-28 min (prendre 20 min)

---

## 📊 Récapitulatif Global par Phase

### **🎯 Planning Débutants (3h exactes)**

```
┌─────────────────────────────────────────────────────────┐
│ SÉANCE 03 - DÉBUTANTS (180 minutes)                    │
├─────────────────────────────────────────────────────────┤
│ 00:00 - 00:25 │ Concepts + Glossaire          │ 25 min │
│ 00:25 - 01:00 │ Découverte pratique           │ 35 min │
│ 01:00 - 01:10 │ ☕ PAUSE                      │ 10 min │
│ 01:10 - 02:10 │ TP Guidé (avec templates)     │ 60 min │
│               │  - Module 1: Contrôleur       │ 20 min │
│               │  - Module 2: Vues (templates) │ 25 min │
│               │  - Module 3: Tests            │ 15 min │
│ 02:10 - 03:00 │ Évaluation simplifiée (2 vues)│ 50 min │
└─────────────────────────────────────────────────────────┘

📝 Notes :
- Templates Blade fournis → gain 15-20 min
- TP Autonome = À la maison (bonus)
- Évaluation simplifiée : 2 vues au lieu de 4
- Fiche mémo A4 autorisée
```

---

### **🚀 Planning Confirmés (3h exactes)**

```
┌─────────────────────────────────────────────────────────┐
│ SÉANCE 03 - CONFIRMÉS (180 minutes)                    │
├─────────────────────────────────────────────────────────┤
│ 00:00 - 00:15 │ Survol concepts               │ 15 min │
│ 00:15 - 00:45 │ Découverte rapide             │ 30 min │
│ 00:45 - 01:45 │ TP Guidé (from scratch)       │ 60 min │
│               │  - Module 1: Contrôleur       │ 20 min │
│               │  - Module 2: Vues             │ 25 min │
│               │  - Module 3: Tests            │ 15 min │
│ 01:45 - 01:55 │ ☕ PAUSE                      │ 10 min │
│ 01:55 - 02:40 │ TP Autonome (Modules 1-3)     │ 45 min │
│               │  - Recherche & Filtres        │ 15 min │
│               │  - Composants Blade           │ 15 min │
│               │  - Validation Avancée         │ 15 min │
│ 02:40 - 03:00 │ Évaluation rapide             │ 20 min │
└─────────────────────────────────────────────────────────┘

📝 Notes :
- Créer vues from scratch (sans templates)
- TP Autonome : 3 modules (Module 5 = maison)
- Évaluation standard : 2 vues minimum
- Possibilité 4 vues si temps (bonus)
```

---

## ⚠️ Ajustements Réalisés (Option 2)

### **Changements par rapport au planning initial :**

| Document | Temps initial | Temps ajusté | Justification |
|----------|---------------|--------------|---------------|
| **01-CONCEPTS** | 15 min | 15-25 min | Document dense (527 lignes) |
| **04-TP-PRATIQUE** | 90 min | 60 min | Templates fournis + code simplifié |
| **05-TP-EXERCICES** | 75 min (5 modules) | 45 min (3 modules) | Modules 4-5 supprimés |
| **06-EVALUATION** | 45 min | 50 min (débutants) | 2 vues au lieu de 4 |
| | | 20 min (confirmés) | Rythme rapide |

### **Solutions pour tenir 3h :**

✅ **Templates Blade fournis** (`resources/views/templates/`)
- Gain : 15-20 min sur Module 2
- Débutants : FORTEMENT recommandé
- Confirmés : Optionnel

✅ **Module 5 (Performance/Export) → Bonus maison**
- PDF/Excel/Cache trop avancé pour 3h
- Nécessite installation packages externes
- Peut être fait en dehors de la séance

✅ **Évaluation simplifiée (débutants)**
- 2 vues obligatoires (index + create) au lieu de 4
- Vues show/edit = optionnel (bonus)
- Fiche mémo A4 autorisée

✅ **Pause intégrée (10 min)**
- Évite la fatigue cognitive
- Timing différent selon parcours

---

## 🎯 Recommandations Formateur

### **Pour les Débutants**

1. **Insister sur l'utilisation des templates** (Module 2)
   - Copier `resources/views/templates/index.blade.php` → `livres/index.blade.php`
   - Gain de temps : 15-20 min

2. **Simplifier l'évaluation**
   - Fournir la migration et le modèle pré-remplis (Partie 1 = vérification)
   - Se concentrer sur contrôleur + 2 vues
   - Autoriser fiche mémo A4

3. **TP Autonome = Maison**
   - Ne pas le faire en séance (pas le temps)
   - Proposer comme exercice bonus pour s'entraîner

### **Pour les Confirmés**

1. **Encourager à créer vues from scratch**
   - Meilleur apprentissage
   - Temps suffisant (60 min TP Guidé)

2. **TP Autonome : Focus sur Modules 1-3**
   - Module 5 (Performance) optionnel
   - 15 min par module (45 min total)

3. **Évaluation rapide (20 min)**
   - 2 vues minimum
   - Possibilité de faire 4 vues si temps (bonus +2 pts)

---

## 📈 Indicateurs de Réussite

### **Checkpoints Temporels**

| Timing | Débutants | Confirmés | Action si retard |
|--------|-----------|-----------|------------------|
| **60 min** | Fin Découverte | Fin TP Module 1 | Accélérer Découverte |
| **90 min** | Fin Module 1 TP | Fin TP Guidé | Fournir code manquant |
| **130 min** | Fin Module 2 TP | Fin TP Autonome | Sauter Module 3 TP |
| **180 min** | Fin Évaluation | Fin Évaluation | Prolonger si possible |

### **Critères de Validation**

**À la fin de la séance, l'étudiant doit avoir :**
- [ ] Créé un contrôleur resource complet (7 méthodes)
- [ ] Développé au moins 2 vues Blade fonctionnelles
- [ ] Implémenté la validation des données
- [ ] Testé le CRUD complet dans le navigateur
- [ ] Réussi l'évaluation (≥ 12/20)

---

## 📚 Ressources Supplémentaires

### **Fichiers d'Aide Fournis**

| Fichier | Utilité | Quand l'utiliser |
|---------|---------|------------------|
| **FICHE-MEMO-A4.md** | Commandes + Syntaxe | Pendant TP + Évaluation |
| **resources/views/templates/** | Templates vues | Module 2 (débutants) |
| **ANALYSE-PEDAGOGIQUE.md** | Analyse complète | Pour le formateur |

### **Liens Documentation**

- [Contrôleurs Laravel](https://laravel.com/docs/controllers)
- [Blade Templates](https://laravel.com/docs/blade)
- [Validation](https://laravel.com/docs/validation)
- [Form Requests](https://laravel.com/docs/validation#form-request-validation)

---

**📅 Date de création :** 6 octobre 2025  
**👨‍🏫 Public :** BTS2 SIO SLAM  
**⏱️ Durée totale :** 3 heures (180 minutes exactes)
