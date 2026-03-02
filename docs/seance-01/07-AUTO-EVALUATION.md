# ✅ GUIDE COMPLET D'AUTO-ÉVALUATION - SÉANCE 1

## 🚦 Checklistd'Auto-Évaluation

### ✅ Minimum Requis (Niveau 1)

Avant de commencer l'évaluation formelle, vérifiez que vous maîtrisez ces points:

- [ ] Définir chaque lettre de MVC (Model, View, Controller)
- [ ] Créer une route simple `GET /page`
- [ ] Créer un contrôleur avec une méthode
- [ ] Créer une view et la retourner
- [ ] Utiliser une variable en Blade avec `{{ $variable }}`
- [ ] Créer une boucle `@foreach` en Blade
- [ ] Créer un lien avec `route()` helper
- [ ] Naviguer dans l'arborescence Laravel

**Score:** __ / 8

Si vous avez moins de 6: **Relisez [01-CONCEPTS-MVC.md](01-CONCEPTS-MVC.md) et [04-TP-ROUTES-SIMPLES.md](04-TP-ROUTES-SIMPLES.md)**

---

### 🎯 Intermédiaire (Niveau 2)

Une fois le niveau 1 maîtrisé:

- [ ] Créer une route paramétrée `GET /livre/{id}`
- [ ] Utiliser les paramètres dans le contrôleur
- [ ] Utiliser les contraintes `->where('id', '[0-9]+')`
- [ ] Utiliser `@if @else` en Blade
- [ ] Créer un layout avec `@extends` et `@section`
- [ ] Comprendre Eager loading `.with()`
- [ ] Utiliser `withCount()` pour compter
- [ ] Créer des partials réutilisables

**Score:** __ / 8

Si vous avez moins de 6: **Relisez [02-GLOSSAIRE-LARAVEL.md](02-GLOSSAIRE-LARAVEL.md) et [03-TP-DECOUVERTE-APP.md](03-TP-DECOUVERTE-APP.md)**

---

### 🚀 Avancé (Niveau 3 - Bonus)

Pour compléter votre maîtrise:

- [ ] Utiliser la pagination `.paginate(15)`
- [ ] Créer plusieurs routes groupées
- [ ] Utiliser les conventions de nommage Laravel
- [ ] Organiser les vues dans des dossiers
- [ ] Chercher (LIKE) avec le query builder
- [ ] Trier les résultats `.orderBy()`
- [ ] Implémenter des extensions (voir ci-dessous)
- [ ] Mettre en place JavaScript pour des favoris

**Score:** __ / 8

---

## 🚀 Extensions - Pour Aller Plus Loin

### Extension 1️⃣ : Navigation Dynamique
**Concept:** Afficher les catégories dans une navbar en boucle

**Fichier solution:** [solutions/seance-01/resources/views](../../solutions/seance-01/resources/views)

**Compétences:** Boucles Blade, relations, query builder

---

### Extension 2️⃣ : Statistiques Dashboard
**Concept:** Afficher nombre de livres, catégories, etc

**Fichier solution:** [solutions/seance-01/app/Http/Controllers/HomeController.php](../../solutions/seance-01/app/Http/Controllers/HomeController.php)

**Compétences:** `withCount()`, statistiques, formatage données

---

### Extension 3️⃣ : Barre de Recherche
**Concept:** Chercher des livres par titre ou auteur

**Fichier solution:** [solutions/seance-01/app/Http/Controllers/LivreController.php](../../solutions/seance-01/app/Http/Controllers/LivreController.php)

**Compétences:** Paramètres GET, LIKE, conditions OR

---

### Extension 4️⃣ : Pagination
**Concept:** Limiter le nombre de résultats par page

**Code:** `$livres = Livre::paginate(15);`

**Compétences:** Pagination, navigation, performances

---

### Extension 5️⃣ : Système de Favoris
**Concept:** Marquer les livres en favoris (localStorage)

**Compétences:** JavaScript basique, localStorage API, événements DOM

---

## 📊 Grille Finale de Notation

| Compétence | Points | ✅/❌ | Notes |
|---|---|---|---|
| MVC compris | 3 | | |
| Routes créées | 3 | | |
| Vues Blade | 3 | | |
| Controllers | 3 | | |
| Extensions réalisées | 2 | | Bonus |
| Sécurité + Bonnes pratiques | 3 | | |
| **TOTAL** | **/17** | | |

---

**Score final:**
- **15-17:** Excellent 🎓
- **12-14:** Bon 👍
- **10-11:** Satisfaisant ✅
- **< 10:** À revoir 📚

---

**Prêt pour la séance 2 ?** → [docs/seance-02/00-README.md](../seance-02/00-README.md)

Solutions complètes: [solutions/seance-01/](../../solutions/seance-01/)

