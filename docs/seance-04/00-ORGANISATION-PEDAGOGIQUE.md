# 📚 Organisation Pédagogique - Séance 04

**Guide pour comprendre la structure des documents et la progression pédagogique**

---

## 🎯 Vue d'Ensemble

La séance 04 est organisée en **7 documents** suivant une progression pédagogique claire :

```
🔐 SÉANCE 04 - Authentification & Autorisations
│
├── 00-README.md ................................. Vue d'ensemble et index
├── 00-ORGANISATION-PEDAGOGIQUE.md ............... Ce document
│
├── 📖 PARTIE THÉORIQUE (Concepts)
│   ├── 01-CONCEPTS-AUTH.md ...................... Concepts fondamentaux
│   └── 02-GLOSSAIRE-AUTH.md ..................... Vocabulaire technique
│
├── 🛠️ PARTIE PRATIQUE (Application)
│   ├── 03-TP-SETUP-AUTH.md ...................... Configuration initiale
│   ├── 04-TP-FORMULAIRES-AUTH.md ................ Formulaires login/register
│   └── 05-TP-PRATIQUE-EXERCICES.md .............. TP autonome avec rôles
│
├── ✅ PARTIE ÉVALUATION (Certification)
│   ├── 06-EVALUATION-COMPETENCES.md ............. Test final noté
│   └── 07-AUTO-EVALUATION.md .................... Auto-évaluation guidée
│
└── 📁 SOLUTIONS
    └── ../../solutions/seance-04/README.md ...... Code complet et extensions
```

---

## 📖 Différence entre les Types de Documents

### **1. Concepts (01, 02) - Théorie**
**🎓 Objectif :** Comprendre la sécurité avant de l'implémenter

- **Format :** Cours théorique avec exemples
- **Lecture :** 15-20 minutes par document
- **Activité :** Lire, comprendre, prendre des notes
- **Pré-requis :** Séances 1-3 terminées
- **Résultat attendu :** Compréhension de l'authentification et des autorisations

**Exemples :**
- `01-CONCEPTS-AUTH.md` : Sessions, hashage, middleware, CSRF
- `02-GLOSSAIRE-AUTH.md` : Auth::attempt(), Hash::make(), middleware, gates

---

### **2. TP Pratique (03, 04, 05) - Application**

#### **A. TP Setup (03) - Configuration Initiale**
**🔑 Objectif :** Préparer le système d'authentification

- **Format :** Tutorial pas à pas avec commandes
- **Durée :** 45 minutes
- **Activité :** Configurer, créer tables, contrôleurs
- **Assistance :** Instructions détaillées
- **Résultat attendu :** Base de l'authentification prête

**Caractéristiques :**
- ✅ Migrations utilisateurs
- ✅ Création contrôleurs AuthController
- ✅ Configuration des routes
- ✅ Vérification de la configuration

**Structure typique :**
```bash
# Créer la migration utilisateurs
php artisan make:migration add_role_to_users_table

# Créer le contrôleur
php artisan make:controller AuthController
```

---

#### **B. TP Formulaires (04) - Login/Register**
**📝 Objectif :** Créer les interfaces d'authentification

- **Format :** Tutorial guidé avec code Blade
- **Durée :** 60 minutes
- **Activité :** Créer formulaires, valider, tester
- **Assistance :** Code complet fourni
- **Résultat attendu :** Utilisateurs peuvent s'inscrire et se connecter

**Caractéristiques :**
- ✅ Formulaire register avec validation
- ✅ Formulaire login avec "Se souvenir de moi"
- ✅ Gestion des erreurs de validation
- ✅ Messages flash de succès/erreur
- ✅ Logout fonctionnel

**Exemple de formulaire :**
```blade
<form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    @error('email')
        <span>{{ $message }}</span>
    @enderror
    <button type="submit">S'inscrire</button>
</form>
```

---

#### **C. TP Autonome (05) - Rôles et Permissions**
**💪 Objectif :** Implémenter un système de rôles complet

- **Format :** Exercices progressifs à réaliser seul
- **Durée :** 90 minutes
- **Activité :** Développer, tester, valider
- **Assistance :** Consignes uniquement, solutions à la fin
- **Résultat attendu :** Système complet avec admin/user/bibliothécaire

**Modules :**
1. **Ajouter le champ `role` à la table users**
2. **Créer un middleware `CheckRole`**
3. **Protéger les routes admin avec le middleware**
4. **Créer un dashboard différent par rôle**
5. **Tester avec plusieurs utilisateurs**

**Validation :**
- [ ] Admin peut accéder au dashboard admin
- [ ] User ne peut PAS accéder au dashboard admin
- [ ] Bibliothécaire peut gérer les livres
- [ ] Redirection 403 si non autorisé

---

### **3. Évaluation (06, 07) - Certification**

#### **A. Évaluation Formelle (06)**
**📊 Objectif :** Valider les compétences acquises

- **Format :** Questions théoriques + exercices pratiques
- **Durée :** 2 heures
- **Activité :** Répondre aux questions, coder, tester
- **Notation :** Grille de notation fournie
- **Pré-requis :** Tous les TPs réalisés

**Structure :**
- **Partie 1 :** Questions théoriques (20 points)
  - Expliquer CSRF, sessions, hashage
- **Partie 2 :** Exercices pratiques (60 points)
  - Créer un système d'authentification complet
  - Implémenter les rôles
  - Tester la sécurité

**Barème :**
- 85-100 : Excellent ⭐⭐⭐
- 70-84 : Très Bien ⭐⭐
- 55-69 : Bien ⭐
- 40-54 : Satisfaisant ✅
- < 40 : À revoir 📚

---

#### **B. Auto-Évaluation (07)**
**✅ Objectif :** Vérifier sa progression avant l'éval formelle

- **Format :** Checklists par niveau de compétence
- **Durée :** 30 minutes
- **Activité :** Cocher ce qu'on sait faire
- **Assistance :** Renvoi vers les documents à relire
- **Résultat attendu :** Connaître ses forces et faiblesses

**Niveaux :**
- **Niveau 1 ⭐** : Authentification basique (essentiel)
- **Niveau 2 ⭐⭐** : Rôles et middleware (important)
- **Niveau 3 ⭐⭐⭐** : Sécurité avancée (bonus)

**Exemple de checklist :**
```markdown
### Niveau 1 - Authentification (Essentiel)
- [ ] Créer un formulaire de login
- [ ] Vérifier credentials avec Auth::attempt()
- [ ] Hasher un mot de passe avec Hash::make()
- [ ] Protéger une route avec middleware('auth')
```

---

## 🗺️ Parcours Pédagogique Recommandé

### **Parcours Standard (6-7 heures)**
```
1. [30 min] Lire 01-CONCEPTS-AUTH + 02-GLOSSAIRE-AUTH
2. [45 min] Faire 03-TP-SETUP-AUTH (configuration)
3. [60 min] Faire 04-TP-FORMULAIRES-AUTH (login/register)
4. [90 min] Faire 05-TP-PRATIQUE-EXERCICES (rôles)
5. [30 min] Faire 07-AUTO-EVALUATION
6. [2h] Faire 06-EVALUATION-COMPETENCES
```

### **Parcours Rapide (4 heures)** ⚡
Pour les étudiants à l'aise :
```
1. [15 min] Survoler les concepts
2. [30 min] 03-TP-SETUP-AUTH
3. [45 min] 04-TP-FORMULAIRES-AUTH
4. [90 min] 05-TP-PRATIQUE-EXERCICES
5. [60 min] 06-EVALUATION-COMPETENCES
```

### **Parcours Approfondissement (8-9 heures)** 🚀
Pour ceux qui veulent aller plus loin :
```
1. [45 min] Lire tous les concepts + prendre notes
2. [60 min] 03-TP-SETUP-AUTH + expérimenter
3. [90 min] 04-TP-FORMULAIRES-AUTH + personnaliser
4. [2h] 05-TP-PRATIQUE-EXERCICES + extensions
5. [30 min] 07-AUTO-EVALUATION
6. [2h] 06-EVALUATION-COMPETENCES
7. [1h] Extensions : 2FA, Email verification
```

---

## 📊 Comment Utiliser ce Document

### **Avant de Commencer**
1✅ Vérifier les pré-requis : Séances 1-3 terminées
2. ✅ S'assurer que l'application BiblioTech fonctionne
3. ✅ Avoir accès à `php artisan tinker`
4. ✅ Savoir créer des migrations et modèles

### **Pendant la Séance**
1. Suivre l'ordre des documents (01 → 02 → 03 → 04 → 05)
2. Ne pas sauter de TP, chacun prépare le suivant
3. Tester après chaque modification
4. Consulter les solutions si bloqué > 15 minutes

### **En Cas de Blocage**
1. Relire le document théorique correspondant
2. Consulter le glossaire (02-GLOSSAIRE-AUTH.md)
3. Vérifier la solution dans `solutions/seance-04/`
4. Demander de l'aide à l'enseignant

### **Après la Séance**
1. Faire l'auto-évaluation (07-AUTO-EVALUATION.md)
2. Identifier les points faibles
3. Refaire les exercices non maîtrisés
4. Préparer l'évaluation formelle

---

## 🎯 Compétences Validées

À la fin de cette séance, vous devez être capable de :

### **🔐 Authentification**
- [ ] Créer un système de register/login/logout
- [ ] Hasher les mots de passe avec bcrypt
- [ ] Gérer les sessions utilisateur
- [ ] Implémenter "Se souvenir de moi"

### **🛡️ Autorisations**
- [ ] Créer un système de rôles (admin/user/etc)
- [ ] Créer un middleware de vérification de rôle
- [ ] Protéger des routes selon le rôle
- [ ] Afficher/masquer du contenu selon le rôle

### **🔒 Sécurité**
- [ ] Protéger contre les attaques CSRF
- [ ] Implémenter le rate limiting
- [ ] Logger les tentatives échouées
- [ ] Valider les données utilisateur

### **✅ Tests**
- [ ] Tester le login avec un utilisateur valide
- [ ] Tester le register avec données invalides
- [ ] Tester la protection des routes
- [ ] Vérifier les redirections selon le rôle

---

## 📚 Correspondance avec le Référentiel BTS SIO

Cette séance couvre les compétences suivantes du référentiel :

| Compétence | Bloc | Description |
|-----------|------|-------------|
| **C1.3** | Bloc 1 | Développer la présence en ligne de l'organisation |
| **C2.2** | Bloc 2 | Concevoir une solution applicative |
| **C2.3** | Bloc 2 | Développer une solution applicative |
| **C4.1** | Bloc 4 | Gérer le patrimoine informatique |

**Savoirs associés :**
- S2.1 : Programmation objet
- S2.2 : Conception et développement d'applications
- S4.2 : Sécurité informatique

---

## ⚠️ Points d'Attention Importants

### **Sécurité Critique**
- ⚠️ **JAMAIS** stocker un mot de passe en clair
- ⚠️ **TOUJOURS** utiliser `Hash::make()` pour hasher
- ⚠️ **TOUJOURS** ajouter `@csrf` dans les formulaires
- ⚠️ **TOUJOURS** valider les données utilisateur

### **Erreurs Courantes**
- ❌ Oublier `@csrf` dans un formulaire → Erreur 419
- ❌ Ne pas hasher le password → Faille de sécurité
- ❌ Ne pas vérifier le rôle → N'importe qui accède partout
- ❌ Session trop longue → Risque de hijacking

### **Bonnes Pratiques**
- ✅ Utiliser `Auth::attempt()` pour vérifier credentials
- ✅ Utiliser `auth()->user()` pour récupérer l'utilisateur
- ✅ Créer des middleware pour les vérifications de rôle
- ✅ Logger les actions sensibles (login échoué, etc.)
- ✅ Tester avec plusieurs utilisateurs de rôles différents

---

## 🔗 Liens vers les Ressources

### **Documents de la Séance**
- [Vue d'ensemble](00-README.md)
- [Concepts Authentification](01-CONCEPTS-AUTH.md)
- [Glossaire Technique](02-GLOSSAIRE-AUTH.md)
- [TP Setup](03-TP-SETUP-AUTH.md)
- [TP Formulaires](04-TP-FORMULAIRES-AUTH.md)
- [TP Autonome](05-TP-PRATIQUE-EXERCICES.md)
- [Évaluation](06-EVALUATION-COMPETENCES.md)
- [Auto-Évaluation](07-AUTO-EVALUATION.md)

### **Solutions et Extensions**
- [Solutions Complètes](../../solutions/seance-04/README.md)
- [Extensions Avancées](../../solutions/seance-04/README.md#extensions)

### **Ressources Externes**
- [Laravel Authentication Documentation](https://laravel.com/docs/authentication)
- [Laravel Authorization Documentation](https://laravel.com/docs/authorization)
- [OWASP Authentication Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html)

---

**🎓 Prêt à sécuriser votre application ? Commencez par [01-CONCEPTS-AUTH.md](01-CONCEPTS-AUTH.md) !**

*Dernière mise à jour : Février 2026*
