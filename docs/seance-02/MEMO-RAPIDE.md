# 📝 Mémo Rapide - Séance 02

## 🚀 Démarrage Express

### Je débute → Parcours Standard (3h)
```bash
1. Lire 01-CONCEPTS (20 min)
2. Lire 02-GLOSSAIRE (15 min)
3. Faire 03-DECOUVERTE (45 min)
4. Faire 04-TP-PRATIQUE-MIGRATIONS (60 min)
5. Faire 06-EVALUATION (45 min)
```

### Je connais les bases → Parcours Complet (5h)
```bash
1. Survoler 01-02 (10 min)
2. Faire 03-DECOUVERTE (30 min)
3. Faire 04-TP-PRATIQUE-MIGRATIONS (60 min)
4. Faire 05-TP-PRATIQUE-EXERCICES (150 min - 5 modules)
5. Faire 06-EVALUATION (45 min)
```

### Je suis expert → Parcours Avancé (6h+)
```bash
Parcours Complet + 07-CICD-GITHUB-ACTIONS (60 min)
```

---

## 🔍 Quelle est la Différence ?

| Fichier | C'est quoi ? | Je fais quoi ? | Durée |
|---------|--------------|----------------|-------|
| **03** | Découverte | J'observe (Tinker) | 45 min |
| **04** | TP Guidé | Je crée (code fourni) | 60 min |
| **05** | TP Autonome | Je crée (indices) | 150 min |
| **06** | Évaluation | Je valide (noté) | 45 min |

---

## ⚡ Commandes Essentielles

```bash
# Créer la base SQLite
touch database/database.sqlite

# Lancer les migrations
php artisan migrate

# Vérifier l'état
php artisan migrate:status

# Peupler avec des données
php artisan migrate:fresh --seed

# Explorer avec Tinker
php artisan tinker
>>> App\Models\Category::all()
>>> App\Models\Livre::with('category')->get()
```

---

## 📚 Documents Utiles

- 📖 **Organisation complète** → `00-ORGANISATION-PEDAGOGIQUE.md`
- 📊 **Structure visuelle** → `STRUCTURE-VISUELLE.md`
- 🔄 **Historique des changements** → `CHANGELOG-REFONTE.md`
- 📋 **Index principal** → `00-README.md`

---

## ❓ FAQ Rapide

**Q: Je suis perdu, par où commencer ?**
→ Lis `00-ORGANISATION-PEDAGOGIQUE.md`

**Q: Quelle est la différence entre 04 et 05 ?**
→ 04 = guidé (code fourni), 05 = autonome (indices)

**Q: C'est quoi un "TP Pratique" ?**
→ Un exercice où tu crées quelque chose (contrairement à 03 où tu observes)

**Q: Je suis en retard, que faire ?**
→ Utilise `08-QUICK-START-SQLITE.md` (2 min)

**Q: Comment je sais si j'ai réussi ?**
→ Fais `06-EVALUATION` (test noté sur 20)

---

**✅ Tu es prêt ! Commence par `01-CONCEPTS-DATABASE.md`**
