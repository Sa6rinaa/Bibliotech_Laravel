@echo off
chcp 65001 >nul
echo ========================================
echo Installation BiblioTech Laravel - SQLite
echo ========================================
echo.

cd /d "%~dp0\.."

echo [1/10] Verification de PHP...
where php >nul 2>&1
if errorlevel 1 (
    echo ERREUR: PHP non trouve
    echo Installez PHP 8.3+ depuis https://windows.php.net/download/
    pause
    exit /b 1
)
php -v | findstr "PHP 8"
echo.

echo [2/10] Verification de Composer...
where composer >nul 2>&1
if errorlevel 1 (
    echo ERREUR: Composer non trouve
    echo Installez Composer depuis https://getcomposer.org
    pause
    exit /b 1
)
composer --version
echo.

echo [3/10] Installation des dependances PHP...
composer install --no-interaction --optimize-autoloader
echo.

echo [4/10] Configuration .env...
if not exist .env (
    copy .env.example .env
    echo Fichier .env cree
) else (
    echo Fichier .env existe deja
)
echo.

echo [5/10] Generation de la cle d'application...
php artisan key:generate --no-interaction
echo.

echo [6/10] Creation de la base de donnees SQLite...
if not exist "database\database.sqlite" (
    type nul > "database\database.sqlite"
    echo Base de donnees SQLite creee
) else (
    echo Base de donnees SQLite existe deja
)
echo.

echo [7/10] Migration de la base de donnees...
php artisan migrate --force
echo.

echo [8/10] Insertion des donnees de test (seeders)...
php artisan db:seed --class=DatabaseSeeder --force
echo.

echo [9/10] Creation du lien symbolique storage...
php artisan storage:link --no-interaction
echo.

echo [10/10] Nettoyage des caches...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan view:clear >nul 2>&1
php artisan route:clear >nul 2>&1
echo Caches nettoyes
echo.

echo ========================================
echo Installation terminee avec succes!
echo.
echo Pour demarrer l'application :
echo   scripts\start.bat
echo.
echo Ou manuellement :
echo   php artisan serve
echo.
echo Puis accedez a : http://localhost:8000
echo ========================================
pause