# 🚀 Séance 5 — Production & Déploiement

Dernière mise à jour: Février 2026

Bienvenue dans la cinquième et dernière séance du parcours **BiblioTech BTS SIO SLAM**. Cette séance porte sur le déploiement en production, les tests, la qualité de code et le monitoring d'une application Laravel.

---

## 🎯 Objectifs de la Séance

À l'issue de cette séance, vous serez capable de :

- ✅ **Écrire des tests automatisés** (Feature Tests, Unit Tests)
- ✅ **Configurer l'application pour production** (optimisations, sécurité)
- ✅ **Analyser la qualité du code** avec SonarCloud
- ✅ **Déployer sur un serveur** (Heroku, VPS, dedicated)
- ✅ **Mettre en place le monitoring** (logs, error tracking)
- ✅ **Gérer la CI/CD** (GitHub Actions pipeline)
- ✅ **Versionner l'application** (releases et rollback)
- ✅ **Sécuriser l'application en production**

---

## 📂 Sommaire de la Séance

### **1. Concepts Clés**
📖 **[01-CONCEPTS-PRODUCTION.md](01-CONCEPTS-PRODUCTION.md)**
- Architecture production
- Tests automatisés
- Déploiement
- Monitoring et logging
- Rollback et versioning

### **2. Glossaire**
📖 **[02-GLOSSAIRE-DEPLOYMENT.md](02-GLOSSAIRE-DEPLOYMENT.md)**
- Terminologie DevOps
- Commandes essentielles
- Outils et services
- Références rapides

### **3. TP Tests et CI/CD**
🧪 **[03-TP-TESTS-CICD.md](03-TP-TESTS-CICD.md)**
- Écriture de tests
- Configuration GitHub Actions
- Pipeline d'intégration continue

### **3B. TP SonarCloud + GitHub Actions** 🆕
🔍 **[03B-TP-SONARCLOUD.md](03B-TP-SONARCLOUD.md)**
- Configuration SonarCloud sur le projet
- Intégration dans le pipeline GitHub Actions
- Interprétation des métriques qualité (bugs, vulnérabilités, dette technique)
- Correction des problèmes détectés

### **4. TP Déploiement**
🚀 **[04-TP-DEPLOYMENT.md](04-TP-DEPLOYMENT.md)**
- Préparation production
- Déploiement sur serveur
- Configuration domaine

### **5. TP Pratique - Exercices**
💪 **[05-TP-PRATIQUE-EXERCICES.md](05-TP-PRATIQUE-EXERCICES.md)**
- Suite de tests complète
- Déploiement réel
- Setup monitoring

### **6. Évaluation de Compétences**
📊 **[06-EVALUATION-COMPETENCES.md](06-EVALUATION-COMPETENCES.md)**
- Critères d'évaluation
- Validation compétences
- Présentation finale

### **7. Auto-Évaluation**
✅ **[07-AUTO-EVALUATION.md](07-AUTO-EVALUATION.md)**
- Checklist de compétences par niveau
- Extensions possibles
- Grille de notation

---

## 🚀 Points Clés de cette Séance

### **Cycle de Vie d'une Application**

```
Development → Testing → Staging → Production
    ↓           ↓         ↓         ↓
   .env      Tests      Config   Monitoring
   local     unitaires   sécurité  logs
            feat tests   qualité   metrics
```

### **Tests Automatisés**

```
Unit Tests (Modèles, Services)
    ↓
Feature Tests (Routes, Controllers)
    ↓
Integration Tests (DB, APIs)
    ↓
All pass → Déploiement OK
```

### **Pipeline CI/CD avec Qualité**

```
Git push → GitHub Actions
    ↓
Run tests (PHPUnit)
    ↓
Code quality (PHPStan, Pint)
    ↓
SonarCloud analysis 🆕
    ↓
Coverage check
    ↓
Deploy to staging
    ↓
Deploy to production
```

---

## 📚 Pré-requis

- ✅ Toutes les séances 1-4 complétées
- ✅ Application Laravel complète
- ✅ Git configuré
- ✅ GitHub Actions connaissance basique

---

## 🔧 Préparation

### **1. Vérifier structure app**
```bash
# Tests directory
ls tests/Feature
ls tests/Unit

# Config files
ls config/
```

### **2. Dépendances de test**
```bash
composer require --dev phpunit/phpunit
composer require --dev laravel/tinker
```

### **3. .env.testing**
```env
APP_ENV=testing
DB_DATABASE=testing.sqlite
```

---

## ✅ Livrables à la fin de cette séance

- [x] Suite de tests développée (50+ tests)
- [x] GitHub Actions pipeline configuré
- [x] SonarCloud configuré avec Quality Gate 🆕
- [x] Application déployée en production
- [x] Monitoring et alertes en place
- [x] Documentation complète
- [x] Rollback procedure testée

---

## 📖 Ressources Complètes

| Ressource | Type | Durée | Lien |
|-----------|------|-------|------|
| Concepts Production | 📖 Course | 30 min | [01-CONCEPTS-PRODUCTION.md](01-CONCEPTS-PRODUCTION.md) |
| Glossaire Deployment | 📚 Reference | 20 min | [02-GLOSSAIRE-DEPLOYMENT.md](02-GLOSSAIRE-DEPLOYMENT.md) |
| Tests et CI/CD | 🧪 Lab | 60 min | [03-TP-TESTS-CICD.md](03-TP-TESTS-CICD.md) |
| **SonarCloud** 🆕 | 🔍 Lab | 45 min | [03B-TP-SONARCLOUD.md](03B-TP-SONARCLOUD.md) |
| Déploiement | 🚀 Lab | 90 min | [04-TP-DEPLOYMENT.md](04-TP-DEPLOYMENT.md) |
| Exercices Pratiques | 💪 Hands-on | 120 min | [05-TP-PRATIQUE-EXERCICES.md](05-TP-PRATIQUE-EXERCICES.md) |
| Évaluation Finale | 📊 Project | 180 min | [06-EVALUATION-COMPETENCES.md](06-EVALUATION-COMPETENCES.md) |

**Total: ~10 heures de contenu**

---

## 🎯 Progression Finale

```
Séance 1: Routes & MVC
    ↓
Séance 2: Models & Database
    ↓
Séance 3: Controllers & Views
    ↓
Séance 4: Authentication & Roles
    ↓
Séance 5: Production & Deployment ← Nous sommes ici (FINAL)
    ↓
🎓 Application prête pour entretien d'embauche !
```

---

## 💡 Objectif Final

À la fin de cette séance, vous avez :
- 🎓 Une application Laravel complète et sécurisée
- 📊 Des tests automatisés qui passent
- 🔍 Une analyse qualité SonarCloud avec Quality Gate
- 🚀 L'application déployée en production
- 📈 Monitoring et alertes actifs
- 📚 Documentation professionnelle
- 💼 Un projet à présenter en entretien

---

## 🏆 Compétences BTS SIO SLAM Acquises

### **Concepts Système**
- ✅ Architecture client-serveur
- ✅ Protocoles HTTP/HTTPS
- ✅ Bases de données relationnelles

### **Développement**
- ✅ Architecture MVC
- ✅ Sécurité web
- ✅ Tests automatisés
- ✅ Qualité de code (SonarCloud)

### **DevOps**
- ✅ Versionning (Git)
- ✅ CI/CD
- ✅ Analyse qualité continue
- ✅ Déploiement
- ✅ Monitoring

---

## 💪 Conseils pour Réussir

1. **Les tests d'abord** - Écrire les tests avant le code
2. **Lire les logs** - Toujours vérifier les logs de déploiement
3. **Qualité continue** - Consulter SonarCloud après chaque push
4. **Test en staging** - Tester avant production
5. **Monitoring actif** - Surveiller les premières heures
6. **Documentation à jour** - README avec instructions et badges

---

Bon courage pour cette dernière séance ! 🎉

Vous allez de débutant à professionnel junior en Laravel ! 🚀
