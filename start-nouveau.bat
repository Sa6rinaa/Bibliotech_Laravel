@echo off
echo ===========================================
echo  BIBLIOTECH - NOUVEAU PROJET PROPRE
echo ===========================================
echo.

cd /d "C:\Users\gaill\Documents\VSCode\bibliotech-laravel-bts-sio-local\bibliotech-laravel-bts-sio-main\bibliotech-nouveau"

echo Demarrage du serveur Laravel...
php artisan serve --port=8001

pause