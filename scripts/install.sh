#!/bin/bash

echo "========================================"
echo "Installation BiblioTech Laravel - SQLite"
echo "========================================"
echo

# Se déplacer dans le répertoire parent du script
cd "$(dirname "$0")/.."

echo "[1/10] Vérification de PHP..."
if ! command -v php &> /dev/null; then
    echo "ERREUR: PHP non trouvé"
    echo "Installez PHP 8.3+ avec : sudo apt install php8.3-cli php8.3-sqlite3 php8.3-mbstring"
    exit 1
fi
php -v | grep "PHP 8"
echo

echo "[2/10] Vérification de Composer..."
if ! command -v composer &> /dev/null; then
    echo "ERREUR: Composer non trouvé"
    echo "Installez Composer depuis https://getcomposer.org"
    exit 1
fi
composer --version
echo

echo "[3/10] Installation des dépendances PHP..."
composer install --no-interaction --optimize-autoloader
echo

echo "[4/10] Configuration .env..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Fichier .env créé"
else
    echo "Fichier .env existe déjà"
fi
echo

echo "[5/10] Génération de la clé d'application..."
php artisan key:generate --no-interaction
echo

echo "[6/10] Création de la base de données SQLite..."
if [ ! -f "database/database.sqlite" ]; then
    touch "database/database.sqlite"
    echo "Base de données SQLite créée"
else
    echo "Base de données SQLite existe déjà"
fi
echo

echo "[7/10] Migration de la base de données..."
php artisan migrate --force
echo

echo "[8/10] Insertion des données de test (seeders)..."
php artisan db:seed --class=DatabaseSeeder --force
echo

echo "[9/10] Création du lien symbolique storage..."
php artisan storage:link --no-interaction 2>/dev/null || true
echo

echo "[10/10] Nettoyage des caches..."
php artisan config:clear >/dev/null 2>&1
php artisan cache:clear >/dev/null 2>&1
php artisan view:clear >/dev/null 2>&1
php artisan route:clear >/dev/null 2>&1
echo "Caches nettoyés"
echo

echo "========================================"
echo "Installation terminée avec succès!"
echo
echo "Pour démarrer l'application :"
echo "  bash scripts/start.sh"
echo
echo "Ou manuellement :"
echo "  php artisan serve"
echo
echo "Puis accédez à : http://localhost:8000"
echo "========================================"