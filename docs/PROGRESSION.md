# 📋 PROGRESSION - Formation Laravel BiblioTech

> **Plan de cours simple** pour 5 séances de 3h

---

## 🎯 **VUE D'ENSEMBLE**

### **📊 Résumé Formation**
- **Durée** : 15h (5 séances × 3h)
- **Public** : BTS SIO SLAM
- **Projet** : Application BiblioTech (gestion bibliothèque)
- **Base de données** : SQLite (simple et portable)
- **Environnement** : PHP local ou GitHub Codespace

### **🏆 Objectif Final**
À la fin, chaque étudiant a une application Laravel complète avec SQLite qu'il peut présenter en entretien d'embauche.

---

## 🧭 **Repere Semestre 2 (Post-Stage)**

Si les seances 1 a 3 ont deja ete vues au semestre 1, la reprise post-stage commence
directement a la seance 4. Le depot reste numerote 1-5 pour conserver la progression
complete, mais la reprise peut etre adaptee comme suit :

- **Reprise S2** : commencer a la seance 4 (authentification)
- **Seance 5** : production, deploiement, tests, documentation

Les seances 1 a 3 servent alors de revision rapide ou de reference si besoin.

---

## 📅 **PROGRAMME DÉTAILLÉ**

### **🎯 SÉANCE 1 : Fondations (3h)**
**Objectif** : Comprendre Laravel et créer ses premières pages

#### **Contenu**
- **Installation** : PHP + Laravel avec SQLite
- **MVC** : Model-View-Controller expliqué simplement
- **Routes** : Créer URLs pour accéder aux pages
- **Blade** : Templates pour afficher les pages
- **SQLite** : Base de données simple et portable

#### **Exercices**
- Installer avec `php artisan serve`
- Créer route `/contact`
- Afficher liste des livres
- Personnaliser page d'accueil
- Navigation entre pages

#### **Validation**
- Application fonctionne avec SQLite
- 3 routes créées et fonctionnelles
- Compréhension flux : URL → Contrôleur → Vue

---

### **🗄️ SÉANCE 2 : Base de Données SQLite (3h)**
**Objectif** : Remplacer les données en dur par une base SQLite

#### **Contenu**
- **SQLite** : Avantages pour développement et formation
- **Migrations** : Créer tables dans le fichier SQLite
- **Modèles Eloquent** : Interagir avec SQLite en PHP
- **Relations** : Liens entre tables (livre → catégorie)
- **Seeders** : Remplir SQLite avec des données de test

#### **Exercices**
 - Créer table `livres` et `categories` dans SQLite
 - Modèles `Livre` et `Catégorie` avec relations
- Afficher livres depuis la base SQLite
- Ajouter données via seeders

#### **Validation**
- Base SQLite fonctionnelle
- Données affichées depuis SQLite
- Relations entre livres et catégories
- Fichier `database/database.sqlite` présent

---

### **🎭 SÉANCE 3 : Contrôleurs & Vues Avancées (3h)**
**Objectif** : Maîtriser les contrôleurs resource et développer un système de vues sophistiqué

#### **Contenu**
- **Contrôleurs Resource** : 7 actions CRUD automatiques
- **Route Model Binding** : Injection automatique des modèles
- **Vues Blade Avancées** : Composants réutilisables et layouts
- **Validation Laravel** : Règles robustes et messages personnalisés
- **Interface Responsive** : Bootstrap et UX moderne
- **Messages Flash** : Feedback utilisateur complet

#### **Exercices**
- Générer contrôleur resource complet
- Créer toutes les vues CRUD (index, show, create, edit)
- Implémenter validation avec messages d'erreur
- Développer interface responsive
- Ajouter composants Blade réutilisables

#### **Validation**
- Contrôleur resource avec 7 méthodes fonctionnelles
- Interface utilisateur complète et moderne
- Validation côté serveur robuste
- Navigation fluide entre toutes les pages
- Messages flash appropriés pour chaque action

---

### **🔐 SÉANCE 4 : Authentification (3h)**
**Objectif** : Système de connexion utilisateurs avec SQLite

#### **Contenu**
- **Register/Login** : Inscription et connexion
- **Sessions** : Maintenir utilisateur connecté (fichier)
- **Middleware** : Protéger certaines pages
- **Rôles** : Admin vs utilisateur normal
- **Tables utilisateurs** : Stockage dans SQLite

#### **Exercices**
- Pages inscription/connexion
- Protection page admin
- Affichage conditionnel selon rôle
- Déconnexion

#### **Validation**
- Système auth complet
- Pages protégées fonctionnelles
- Différenciation admin/utilisateur

---

### **🌐 SÉANCE 5 : Production + Migration BDD (3h)**
**Objectif** : Déployer l'application et comprendre les options BDD

#### **Contenu**
- **Tests automatisés** : Vérifier que tout marche
- **SQLite → PostgreSQL** : Migration pour production
- **Hébergement** : Mettre en ligne avec base adaptée
- **Monitoring** : Surveillance erreurs

#### **Exercices**
- Tests unitaires et fonctionnels
- Optionnel : Migration vers PostgreSQL
- Déploiement avec base adaptée (SQLite ou PostgreSQL)
- Configuration SSL + domaine

#### **Validation**
- Application en ligne et accessible
- Tests automatiques passent  
- Compréhension choix SQLite vs PostgreSQL
- Pipeline déploiement fonctionne

---

## 📊 **PRÉREQUIS PAR SÉANCE**

| Séance | Prérequis Étudiant | Prérequis Formateur |
|--------|-------------------|-------------------|
| **1** | Bases HTML/CSS, PHP installé | Connaître Laravel + SQLite |
| **2** | S1 validée + SQLite | Tester migrations SQLite |
| **3** | S2 validée | Exemples validation |
| **4** | S3 validée | Démo auth Laravel |
| **5** | S4 validée | Hébergement configuré |

---

## 💾 **PROGRESSSION BASE DE DONNÉES**

### **🎯 Approche Pédagogique**
1. **Séances 1-4** : SQLite pur (apprentissage bases)
2. **Séance 5** : Production et déploiement

### **Avantages SQLite Formation**
- ✅ **Installation zéro** - Pas de serveur séparé
- ✅ **Portable** - Fichier unique transportable
- ✅ **Débogage facile** - Outils visuels simples
- ✅ **Performance** - Idéal pour développement
- ✅ **BTS SIO** - Suffisant pour toutes compétences

### **Quand introduire PostgreSQL**
- **Séance 5** : Si déploiement nécessite
- **Jamais obligatoire** : SQLite couvre 100% programme BTS

---

## 🎯 **VALIDATION DE PASSAGE**

### **Critères pour passer à la séance suivante**
- **Note ≥ 12/20** à l'évaluation séance
- **Exercices principaux** terminés et fonctionnels
- **Compréhension concepts** vérifiée (questions/réponses)

---


## 🔄 **ADAPTATION POSSIBLE**

### **Si groupe avancé**
- Exercices bonus chaque séance
- Séance 5 peut inclure technologies avancées
- Projet personnel libre en parallèle

### **Si groupe en difficulté**
- Reduire contenu seances 4-5
- Plus d'exercices guidés
- Sessions rattrapage intermédiaires

---



🎯 **Cette progression garantit une montée en compétences régulière et maîtrisée, du débutant à un niveau professionnel junior en Laravel !**
