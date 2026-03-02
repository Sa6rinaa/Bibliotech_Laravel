#!/bin/bash

echo "🔄 Redémarrage du serveur Laravel sur le port 8000..."

# Tuer tous les processus PHP artisan
echo "⏹️  Arrêt des serveurs existants..."
pkill -9 -f "artisan serve" 2>/dev/null
sleep 2

# Vérifier que le port est libre
if ss -ltnp | grep -q ":8000"; then
    echo "❌ Port 8000 encore utilisé, nettoyage forcé..."
    lsof -ti:8000 | xargs kill -9 2>/dev/null
    sleep 1
fi

# Nettoyer les caches Laravel
echo "🧹 Nettoyage des caches..."
php artisan config:clear 2>/dev/null
php artisan cache:clear 2>/dev/null

# Démarrer le serveur sur le port 8000
echo "🚀 Démarrage du serveur sur 0.0.0.0:8000..."
php artisan serve --host=0.0.0.0 --port=8000 > /tmp/laravel-server.log 2>&1 &
SERVER_PID=$!

sleep 2

# Vérifier que le serveur est démarré
if ss -ltnp | grep -q ":8000"; then
    echo "✅ Serveur démarré avec succès sur le port 8000 (PID: $SERVER_PID)"
    echo ""
    echo "📋 Accédez à votre application via :"
    echo "   https://cuddly-eureka-9jw7r7j4jwhpr5-8000.app.github.dev"
    echo ""
    echo "   Ou cliquez sur l'icône 🌐 dans l'onglet PORTS (port 8000)"
    echo ""
else
    echo "❌ Échec du démarrage du serveur"
    echo "Logs :"
    tail -20 /tmp/laravel-server.log
    exit 1
fi
