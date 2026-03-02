# 📚 Organisation Pédagogique - Séance 05

**Guide pour comprendre la structure des documents et la progression pédagogique**

---

## 🎯 Vue d'Ensemble

La séance 05 est organisée en **7 documents** suivant une progression pédagogique claire :

```
🚀 SÉANCE 05 - Production & Déploiement
│
├── 00-README.md ................................. Vue d'ensemble et index
├── 00-ORGANISATION-PEDAGOGIQUE.md ............... Ce document
│
├── 📖 PARTIE THÉORIQUE (Concepts)
│   ├── 01-CONCEPTS-PRODUCTION.md ................ Concepts fondamentaux
│   └── 02-GLOSSAIRE-DEPLOYMENT.md ............... Vocabulaire technique
│
├── 🛠️ PARTIE PRATIQUE (Application)
│   ├── 03-TP-TESTS-CICD.md ...................... Tests + CI/CD
│   ├── 04-TP-DEPLOYMENT.md ...................... Déploiement production
│   └── 05-TP-PRATIQUE-EXERCICES.md .............. TP autonome complet
│
├── ✅ PARTIE ÉVALUATION (Certification)
│   ├── 06-EVALUATION-COMPETENCES.md ............. Test final noté
│   └── 07-AUTO-EVALUATION.md .................... Auto-évaluation guidée
│
└── 📁 SOLUTIONS
    └── ../../solutions/seance-05/README.md ...... Code complet et extensions
```

---

## 📖 Différence entre les Types de Documents

### **1. Concepts (01, 02) - Théorie**
**🎓 Objectif :** Comprendre la production avant de déployer

- **Format :** Cours théorique avec exemples
- **Lecture :** 15-20 minutes par document
- **Activité :** Lire, comprendre, prendre des notes
- **Pré-requis :** Séances 1-4 terminées
- **Résultat attendu :** Compréhension du cycle de vie production

**Exemples :**
- `01-CONCEPTS-PRODUCTION.md` : Tests, CI/CD, monitoring, déploiement
- `02-GLOSSAIRE-DEPLOYMENT.md` : CI/CD, staging, rollback, release

---

### **2. TP Pratique (03, 04, 05) - Application**

#### **A. TP Tests & CI/CD (03)**
**🧪 Objectif :** Mettre en place les tests et le pipeline CI/CD

- **Format :** Tutorial pas à pas
- **Durée :** 60 minutes
- **Activité :** Écrire tests, configurer GitHub Actions
- **Assistance :** Code fourni et explications
- **Résultat attendu :** Pipeline CI/CD fonctionnel

**Caractéristiques :**
- ✅ Tests Feature et Unit
- ✅ Configuration GitHub Actions
- ✅ Exécution automatique des tests
- ✅ Vérification des erreurs

---

#### **B. TP Déploiement (04)**
**🚀 Objectif :** Déployer l'application en production

- **Format :** Tutorial guidé
- **Durée :** 75 minutes
- **Activité :** Configuration serveur, migrations, optimisations
- **Assistance :** Instructions détaillées
- **Résultat attendu :** Application déployée

**Caractéristiques :**
- ✅ Configuration .env production
- ✅ Optimisations (config, routes, views)
- ✅ Migration production
- ✅ HTTPS et sécurité

---

#### **C. TP Autonome (05) - Exercices Complets**
**💪 Objectif :** Appliquer tout le cycle de production

- **Format :** Exercices progressifs
- **Durée :** 90 minutes
- **Activité :** Développer, tester, déployer
- **Assistance :** Consignes uniquement
- **Résultat attendu :** Déploiement complet + monitoring

**Modules :**
1. **Écrire une suite de tests complète**
2. **Mettre en place CI/CD GitHub Actions**
3. **Déployer en production (VPS ou PaaS)**
4. **Configurer monitoring et logs**
5. **Préparer un plan de rollback**

---

### **3. Évaluation (06, 07) - Certification**

#### **A. Évaluation Formelle (06)**
**📊 Objectif :** Valider les compétences acquises

- **Format :** Questions théoriques + exercices pratiques
- **Durée :** 2 heures
- **Activité :** Répondre, coder, déployer
- **Notation :** Grille de notation fournie
- **Pré-requis :** Tous les TPs réalisés

---

#### **B. Auto-Évaluation (07)**
**✅ Objectif :** Vérifier sa progression avant l'éval formelle

- **Format :** Checklists par niveau
- **Durée :** 30 minutes
- **Activité :** Cocher ce qu'on sait faire
- **Assistance :** Renvoi vers documents à relire

---

## 🗺️ Parcours Pédagogique Recommandé

### **Parcours Standard (6-7 heures)**
```
1. [30 min] Lire 01-CONCEPTS-PRODUCTION + 02-GLOSSAIRE-DEPLOYMENT
2. [60 min] Faire 03-TP-TESTS-CICD
3. [75 min] Faire 04-TP-DEPLOYMENT
4. [90 min] Faire 05-TP-PRATIQUE-EXERCICES
5. [30 min] Faire 07-AUTO-EVALUATION
6. [2h] Faire 06-EVALUATION-COMPETENCES
```

### **Parcours Rapide (4 heures)** ⚡
Pour les étudiants à l'aise :
```
1. [15 min] Survoler les concepts
2. [45 min] 03-TP-TESTS-CICD
3. [60 min] 04-TP-DEPLOYMENT
4. [90 min] 05-TP-PRATIQUE-EXERCICES
5. [60 min] 06-EVALUATION-COMPETENCES
```

### **Parcours Approfondissement (8-9 heures)** 🚀
Pour ceux qui veulent aller plus loin :
```
1. [45 min] Lire tous les concepts + notes
2. [60 min] 03-TP-TESTS-CICD + expérimenter
3. [90 min] 04-TP-DEPLOYMENT + personnaliser
4. [2h] 05-TP-PRATIQUE-EXERCICES + extensions
5. [30 min] 07-AUTO-EVALUATION
6. [2h] 06-EVALUATION-COMPETENCES
7. [1h] Extensions : Dusk, Sentry, Blue-Green
```

---

## 📊 Comment Utiliser ce Document

### **Avant de Commencer**
1. ✅ Avoir terminé les séances 1-4
2. ✅ Avoir accès au dépôt GitHub
3. ✅ Savoir exécuter `php artisan test`
4. ✅ Avoir des droits de déploiement

### **Pendant la Séance**
1. Suivre l'ordre des documents (01 → 02 → 03 → 04 → 05)
2. Tester après chaque modification
3. Conserver un journal des erreurs rencontrées
4. Vérifier les logs après déploiement

### **En Cas de Blocage**
1. Relire le document théorique correspondant
2. Consulter le glossaire (02-GLOSSAIRE-DEPLOYMENT.md)
3. Vérifier la solution dans `solutions/seance-05/`
4. Demander de l'aide à l'enseignant

### **Après la Séance**
1. Faire l'auto-évaluation (07-AUTO-EVALUATION.md)
2. Identifier les points faibles
3. Refaire les exercices non maîtrisés
4. Préparer l'évaluation formelle

---

## 🎯 Compétences Validées

À la fin de cette séance, vous devez être capable de :

### **🧪 Tests Automatisés**
- [ ] Créer des tests unitaires et Feature
- [ ] Utiliser `RefreshDatabase` pour isoler les tests
- [ ] Vérifier les réponses HTTP et la base de données
- [ ] Générer une couverture de tests

### **🔄 CI/CD**
- [ ] Configurer GitHub Actions pour Laravel
- [ ] Créer un pipeline de tests
- [ ] Automatiser le déploiement
- [ ] Gérer les secrets dans GitHub

### **🚀 Production**
- [ ] Préparer un .env production sécurisé
- [ ] Exécuter les optimisations Laravel
- [ ] Mettre en place HTTPS
- [ ] Déployer sans downtime (optionnel)

### **📊 Monitoring**
- [ ] Configurer les logs par channel
- [ ] Intégrer un outil d'error tracking
- [ ] Mettre en place des alertes
- [ ] Suivre les performances

---

## ⚠️ Points d'Attention Importants

### **Sécurité Critique**
- ⚠️ **JAMAIS** laisser `APP_DEBUG=true` en production
- ⚠️ **TOUJOURS** utiliser HTTPS
- ⚠️ **TOUJOURS** sauvegarder avant migration
- ⚠️ **NE JAMAIS** versionner `.env` avec secrets

### **Erreurs Courantes**
- ❌ Oublier de lancer les tests avant déploiement
- ❌ Ne pas créer la base SQLite en CI
- ❌ Oublier `php artisan key:generate`
- ❌ Laisser les permissions incorrectes sur storage

### **Bonnes Pratiques**
- ✅ Automatiser les tâches répétitives
- ✅ Utiliser des tags Git pour les releases
- ✅ Avoir un plan de rollback prêt
- ✅ Monitorer les erreurs en temps réel

---

## 🔗 Liens vers les Ressources

### **Documents de la Séance**
- [Vue d'ensemble](00-README.md)
- [Concepts Production](01-CONCEPTS-PRODUCTION.md)
- [Glossaire Deployment](02-GLOSSAIRE-DEPLOYMENT.md)
- [TP Tests & CI/CD](03-TP-TESTS-CICD.md)
- [TP Déploiement](04-TP-DEPLOYMENT.md)
- [TP Exercices](05-TP-PRATIQUE-EXERCICES.md)
- [Évaluation](06-EVALUATION-COMPETENCES.md)
- [Auto-Évaluation](07-AUTO-EVALUATION.md)

### **Solutions et Extensions**
- [Solutions Complètes](../../solutions/seance-05/README.md)
- [Extensions Avancées](../../solutions/seance-05/README.md#extensions)

### **Ressources Externes**
- [Laravel Deployment Documentation](https://laravel.com/docs/deployment)
- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [OWASP Deployment Checklist](https://cheatsheetseries.owasp.org/cheatsheets/Deployment_Checklist.html)

---

**🎓 Prêt à passer en production ? Commencez par [01-CONCEPTS-PRODUCTION.md](01-CONCEPTS-PRODUCTION.md) !**

*Dernière mise à jour : Février 2026*
