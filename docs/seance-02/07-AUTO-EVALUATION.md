# ✅ GUIDE COMPLET D'AUTO-ÉVALUATION - SÉANCE 2

## 🚦 Checklist d'Auto-Évaluation

### ✅ Minimum Requis (Niveau 1)

Avant de commencer l'évaluation formelle, vérifiez que vous maîtrisez ces points:

- [ ] Créer une migration avec `php artisan make:migration`
- [ ] Ajouter des colonnes (`string()`, `integer()`, `text()`)
- [ ] Créer une clé étrangère avec `foreignId()`
- [ ] Comprendre `created_at` et `updated_at` auto-générés
- [ ] Lancer les migrations avec `php artisan migrate`
- [ ] Créer des Models Eloquent correspondant aux tables
- [ ] Utiliser `Model::all()` pour récupérer les données
- [ ] Utiliser `Model::find($id)` pour un enregistrement unique
- [ ] Définir une relation `HasMany` entre Models
- [ ] Définir une relation `BelongsTo` entre Models

**Score:** __ / 10

Si vous avez moins de 8: **Relisez [01-CONCEPTS-DATABASE.md](01-CONCEPTS-DATABASE.md) et [03-DECOUVERTE-DATABASE.md](03-DECOUVERTE-DATABASE.md)**

---

### 🎯 Intermédiaire (Niveau 2)

Une fois le niveau 1 maîtrisé:

- [ ] Utiliser les seeders pour remplir la BD
- [ ] Créer une factory pour générer des données
- [ ] Utiliser `->where()` avec conditions simples
- [ ] Utiliser `->get()` et `->first()`
- [ ] Utiliser `->paginate()` pour paginer
- [ ] Utiliser `.with()` pour eager loading
- [ ] Utiliser `->count()` et `->max()`
- [ ] Modifier un enregistrement avec `->update()`
- [ ] Supprimer un enregistrement avec `->delete()`
- [ ] Utiliser les conventions de nommage (Livre → livres)

**Score:** __ / 10

Si vous avez moins de 8: **Relisez [02-GLOSSAIRE-ELOQUENT.md](02-GLOSSAIRE-ELOQUENT.md) et [04-TP-PRATIQUE-MIGRATIONS.md](04-TP-PRATIQUE-MIGRATIONS.md)**

---

### 🚀 Avancé (Niveau 3 - Bonus)

Pour compléter votre maîtrise:

- [ ] Utiliser `withCount()` pour compter les relations
- [ ] Créer des scopes réutilisables
- [ ] Utiliser les accesseurs/mutateurs
- [ ] Créer une relation Many-to-Many (N-N)
- [ ] Utiliser les soft deletes
- [ ] Implémenter un Polymorphic relationship
- [ ] Utiliser les global scopes
- [ ] Implémenter les extensions (voir ci-dessous)

**Score:** __ / 8

---

## 🚀 Extensions - Pour Aller Plus Loin

### Extension 1️⃣ : Soft Deletes
**Concept:** Supprimer sans vraiment supprimer (archive)

**Fichier solution:** [solutions/seance-02/README.md#extension-1-soft-deletes](../../solutions/seance-02/README.md#extension-1-soft-deletes)

**Compétences:** Migrations avancées, traits, scopes

---

### Extension 2️⃣ : Accesseurs & Mutateurs
**Concept:** Formater automatiquement les données

**Fichier solution:** [solutions/seance-02/README.md#extension-2-accesseurs--mutateurs](../../solutions/seance-02/README.md#extension-2-accesseurs--mutateurs)

**Compétences:** Magic methods, data formatting

---

### Extension 3️⃣ : Scopes Réutilisables
**Concept:** Chaîner les requêtes facilement

**Fichier solution:** [solutions/seance-02/README.md#extension-3-scopes-réutilisables](../../solutions/seance-02/README.md#extension-3-scopes-réutilisables)

**Compétences:** Query builder, chaînage, lisibilité

---

### Extension 4️⃣ : Relations Many-to-Many
**Concept:** Livres avec plusieurs auteurs

**Fichier solution:** [solutions/seance-02/README.md#extension-4-relations-many-to-many](../../solutions/seance-02/README.md#extension-4-relations-many-to-many)

**Compétences:** Tables pivot, relations complexes

---

### Extension 5️⃣ : Factories & Seeders Avancés
**Concept:** Générer beaucoup de données de test

**Fichier solution:** [solutions/seance-02/README.md#extension-5-factories--seeders-avancés](../../solutions/seance-02/README.md#extension-5-factories--seeders-avancés)

**Compétences:** Factories, relations en seed

---

## 📊 Grille Finale de Notation

| Compétence | Points | ✅/❌ | Notes |
|---|---|---|---|
| Migrations | 3 | | |
| Models Eloquent | 3 | | |
| Relations | 3 | | |
| Query Building | 3 | | |
| Seeders | 2 | | |
| Extensions réalisées | 2 | | Bonus |
| Performance (eager loading) | 2 | | |
| **TOTAL** | **/18** | | |

---

**Score final:**
- **16-18:** Excellent 🎓
- **13-15:** Bon 👍
- **11-12:** Satisfaisant ✅
- **< 11:** À revoir 📚

---

**Prêt pour la séance 3 ?** → [docs/seance-03/00-README.md](../seance-03/00-README.md)

Solutions complètes: [solutions/seance-02/](../../solutions/seance-02/)

