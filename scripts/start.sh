#!/bin/bash

# Couleurs pour l'affichage
GREEN='\033[32m'
RED='\033[31m'
YELLOW='\033[33m'
BLUE='\033[34m'
NC='\033[0m' # No Color
SUCCESS='✅'
ERROR='❌'
INFO='ℹ️'
ROCKET='🚀'

echo
echo -e "${BLUE}╔══════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║  ${ROCKET} Démarrage de BiblioTech Laravel                       ║${NC}"
echo -e "${BLUE}╚══════════════════════════════════════════════════════════════╝${NC}"
echo

# Se déplacer dans le répertoire parent du script
cd "$(dirname "$0")/.."

# Vérifier si PHP est installé
if ! command -v php &> /dev/null; then
    echo -e "${ERROR} PHP n'est pas installé ou pas dans le PATH"
    echo -e "${INFO} Veuillez installer PHP"
    exit 1
fi

# Vérifier si on est dans un projet Laravel
if [ ! -f "artisan" ]; then
    echo -e "${ERROR} Console Artisan non trouvée"
    echo -e "${INFO} Assurez-vous d'être dans le répertoire du projet Laravel"
    exit 1
fi

# Vérifier si .env existe
if [ ! -f ".env" ]; then
    echo -e "${YELLOW} Fichier .env manquant, création depuis .env.example...${NC}"
    if [ -f ".env.example" ]; then
        cp ".env.example" ".env"
        echo -e "${SUCCESS} Fichier .env créé"
    else
        echo -e "${ERROR} Fichier .env.example manquant"
        exit 1
    fi
fi

# Vérifier si APP_KEY est configurée
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo -e "${YELLOW} Génération de la clé d'application...${NC}"
    if ! php artisan key:generate; then
        echo -e "${ERROR} Erreur lors de la génération de la clé"
        exit 1
    fi
    echo -e "${SUCCESS} Clé d'application générée"
fi

# Vérifier les dépendances Composer
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW} Installation des dépendances PHP...${NC}"
    if ! command -v composer &> /dev/null; then
        echo -e "${ERROR} Composer n'est pas installé"
        echo -e "${INFO} Téléchargez Composer depuis getcomposer.org"
        exit 1
    fi
    
    if ! composer install --no-dev --optimize-autoloader; then
        echo -e "${ERROR} Erreur lors de l'installation des dépendances"
        exit 1
    fi
    echo -e "${SUCCESS} Dépendances PHP installées"
fi

# Nettoyer le cache Laravel
echo -e "${INFO} Nettoyage du cache Laravel..."
php artisan config:clear >/dev/null 2>&1
php artisan cache:clear >/dev/null 2>&1
php artisan view:clear >/dev/null 2>&1

# Vérifier la base de données
echo -e "${INFO} Vérification de la base de données..."
if ! php artisan migrate:status >/dev/null 2>&1; then
    echo -e "${YELLOW} Base de données non configurée ou inaccessible${NC}"
    echo -e "${INFO} Vous devrez configurer la base de données dans .env"
else
    echo -e "${SUCCESS} Base de données accessible"
fi

# Créer le lien symbolique pour le storage
if [ ! -L "public/storage" ] && [ ! -d "public/storage" ]; then
    echo -e "${INFO} Création du lien symbolique storage..."
    if php artisan storage:link >/dev/null 2>&1; then
        echo -e "${SUCCESS} Lien storage créé"
    fi
fi

# Vérifier si le port 8000 est libre
if netstat -ln 2>/dev/null | grep -q ":8000 "; then
    echo -e "${YELLOW} Le port 8000 est déjà utilisé${NC}"
    echo -e "${INFO} L'application sera démarrée sur un autre port"
    PORT_OPTION=""
else
    PORT_OPTION="--port=8000"
fi

echo
echo -e "${GREEN}🚀 Démarrage du serveur Laravel...${NC}"
echo -e "${INFO} L'application sera accessible dans votre navigateur"
echo -e "${INFO} Appuyez sur Ctrl+C pour arrêter le serveur"
echo

# Démarrer le serveur de développement
php artisan serve $PORT_OPTION

# Si on arrive ici, le serveur s'est arrêté
echo
echo -e "${INFO} Serveur arrêté"