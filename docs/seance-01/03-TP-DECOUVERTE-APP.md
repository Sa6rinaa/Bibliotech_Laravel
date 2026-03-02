# 🚀 EXERCICES SUPPLÉMENTAIRES - SÉANCE 1

## 🎯 **TP0 - Découverte Guidée BiblioTech (15 minutes)**

### **🎪 Objectif**
Faire une exploration complète de l'application BiblioTech pour comprendre sa structure et identifier les éléments MVC dans l'interface utilisateur.

### **📋 Prérequis**
- ✅ GitHub Codespace créé et fonctionnel
- ✅ BiblioTech accessible sur http://localhost:8000
- ✅ Navigateur ouvert avec onglets multiples

---

### **🕵️ Étape 1 : Tour de l'Interface (5 minutes)**

#### **1.1 Page d'Accueil - Vue d'Ensemble**
1. **Ouvrir** http://localhost:8000
2. **Observer** la structure générale :
   - 🏠 **Header** : Logo BiblioTech + Navigation
   - 📊 **Hero Section** : Titre principal + statistiques
   - 📚 **Aperçu Catalogue** : Premiers livres affichés
   - 🔗 **Footer** : Liens et informations

3. **Identifier les données dynamiques** :
   ```
   📊 Statistiques temps réel :
   - "15 livres au catalogue"
   - "5 catégories disponibles" 
   - "Dernière mise à jour"
   
   📚 Livres affichés :
   - Titres, auteurs, descriptions
   - Images de couverture
   - Badges de catégorie
   ```

#### **1.2 Navigation Principale**
4. **Cliquer sur "Catalogue"** dans la navigation
   - Observer la liste complète des livres
   - Tester le responsive (redimensionner fenêtre)
   - Noter l'URL : `/catalogue`

5. **Cliquer sur "Recherche"** 
   - Tester une recherche : "Prince"
   - Observer les résultats filtrés
   - Noter l'URL : `/recherche?q=Prince`

#### **1.3 Pages de Détail**
6. **Cliquer sur un livre** depuis le catalogue
   - Observer la page détaillée complète
   - Noter l'URL : `/livre/1` (ou autre ID)
   - Tester plusieurs livres pour voir la différence d'ID

---

### **🔍 Étape 2 : Chasse aux Éléments MVC (5 minutes)**

#### **2.1 Identifier les VIEWS (Ce que vous voyez)**
7. **Compléter le tableau** :

| Page Visitée | URL | Contenu Principal | Éléments Répétés |
|--------------|-----|-------------------|------------------|
| Accueil | `/` | Hero + stats + aperçu | Header, Footer |
| Catalogue | `/catalogue` | Liste tous livres | Navigation, Cards |
| Détail | `/livre/{id}` | Info complète livre | Layout, Sidebar |
| Recherche | `/recherche` | Résultats filtrés | Formulaire, Liste |

#### **2.2 Identifier les MODELS (Les données)**
8. **Lister les types de données observées** :
   ```
   📚 LIVRE :
   - Titre : "Le Petit Prince"
   - Auteur : "Antoine de Saint-Exupéry"
   - Description : "L'histoire d'un petit prince..."
   - Catégorie : "Classique"
   - Année : 1943
   - ISBN : 978-2-07-040848-4
   
   📊 STATISTIQUES :
   - Nombre total livres
   - Nombre catégories
   - Livre le plus consulté
   ```

#### **2.3 Identifier les CONTROLLERS (Actions possibles)**
9. **Lister les actions disponibles** :
   ```
   🎮 ACTIONS UTILISATEUR :
   - Afficher la page d'accueil
   - Lister tous les livres (catalogue)
   - Voir détails d'un livre spécifique
   - Rechercher des livres
   - Naviguer entre les pages
   ```

---

### **🧠 Étape 3 : Analyse Architecture (5 minutes)**

#### **3.1 Connecter Interface → Code**
10. **Ouvrir VS Code dans Codespace** et explorer :
    ```
    📁 Structure Laravel observée :
    ├── routes/web.php          → Définit les URLs vues
    ├── app/Http/Controllers/   → Logique derrière actions
    ├── resources/views/        → Templates des pages vues
    └── public/                 → CSS, JS, images
    ```

11. **Ouvrir `routes/web.php`** et identifier :
    ```php
    // Trouver les routes correspondant aux URLs testées :
    Route::get('/', ...)                    // Page d'accueil
    Route::get('/catalogue', ...)           // Liste livres  
    Route::get('/livre/{id}', ...)          // Détail livre
    Route::get('/recherche', ...)           // Recherche
    ```

#### **3.2 Quiz de Compréhension**
12. **Répondre mentalement** :
    - ❓ Quand je clique sur "Catalogue", qu'est-ce qui se passe côté serveur ?
    - ❓ D'où viennent les données des livres affichées ?
    - ❓ Comment Laravel sait quelle vue afficher pour `/livre/3` ?

---

### **✅ Validation TP0**

**Checklist de réussite :**
- [ ] J'ai exploré toutes les pages principales de BiblioTech
- [ ] J'ai identifié les URLs et leur structure
- [ ] Je comprends la différence entre données statiques et dynamiques
- [ ] J'ai fait le lien entre interface et structure Laravel
- [ ] Je peux expliquer le rôle de chaque dossier dans le projet

**🎯 Objectif atteint :** Vous avez une vision d'ensemble de BiblioTech et commencez à comprendre comment une interface web moderne est construite avec Laravel !

---

