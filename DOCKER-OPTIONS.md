# Options Docker BiblioTech

## Configuration par défaut (Recommandée)

**SQLite + Laravel Artisan** - Installation simple :

```bash
./scripts/install.sh   # ou install.bat sur Windows
php artisan serve
```

✅ **Avantages :**
- Installation rapide
- Pas de dépendances externes  
- Base SQLite portable
- Idéal pour les 8 séances BTS SIO

## Options Docker (Optionnelles)

### 1. Docker Compose Standard

```bash
# Avec PostgreSQL + MailHog
docker-compose up -d

# Accès : http://localhost:8000
# MailHog : http://localhost:8025
```

### 2. Docker avec Profiles

```bash
# MailHog seulement (SQLite dans l'app)
docker-compose up

# MailHog + PostgreSQL
docker-compose --profile database up

# Avec outils admin (Adminer)
docker-compose --profile database --profile tools up
```

### 3. Makefile (si présent)

```bash
make start        # Lance tous les services
make start-lite   # SQLite + MailHog uniquement  
make stop         # Arrêt des services
```

## Choix de la base de données

| Méthode | Base | Avantages | Usage |
|---------|------|-----------|-------|
| `php artisan serve` | SQLite | Simple, portable | **Recommandé séances 1-8** |
| `docker-compose up` | PostgreSQL | Production-like | Tests avancés |

## Recommandation pédagogique

**Pour BTS SIO SLAM :**
1. Commencer par SQLite (séances 1-4)
2. Optionnel : PostgreSQL via Docker (séance 5) pour concepts avancés

La migration des données SQLite → PostgreSQL est couverte en séance 5.
