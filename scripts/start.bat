@echo off
REM Simple start script for Windows (ASCII only)
chcp 65001 >nul

echo.
echo ==============================================
echo Starting BiblioTech (simple Windows script)
echo ==============================================
echo.

REM Check PHP
where php >nul 2>&1
if errorlevel 1 (
    echo ERROR: PHP is not installed or not in PATH
    echo Please install PHP and add it to PATH (e.g. C:\PHP)
    pause
    exit /b 1
)

REM Check artisan
if not exist "artisan" (
    echo ERROR: artisan not found. Are you in the project root?
    pause
    exit /b 1
)

REM Ensure .env exists
if not exist ".env" (
    echo Creating .env from .env.example
    if exist ".env.example" (
        copy ".env.example" ".env" >nul
        echo .env created
    ) else (
        echo ERROR: .env.example missing
        pause
        exit /b 1
    )
)

REM Generate app key if missing
findstr /C:"APP_KEY=base64:" .env >nul 2>&1
if errorlevel 1 (
    echo Generating application key...
    php artisan key:generate
    if errorlevel 1 (
        echo ERROR: failed to generate app key
        pause
        exit /b 1
    )
    echo App key generated
)

REM Install Composer deps if needed
if not exist "vendor" (
    echo Installing PHP dependencies (composer)...
    where composer >nul 2>&1
    if errorlevel 1 (
        echo ERROR: Composer not found. Install Composer (https://getcomposer.org)
        pause
        exit /b 1
    )
    composer install --no-dev --optimize-autoloader
    if errorlevel 1 (
        echo ERROR: composer install failed
        pause
        exit /b 1
    )
    echo Composer dependencies installed
)

echo Clearing caches...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan view:clear >nul 2>&1

echo Checking database connection (migrations)...
php artisan migrate:status >nul 2>&1
if errorlevel 1 (
    echo WARNING: database might not be configured or accessible. Check .env
) else (
    echo Database accessible
)

REM Create storage link if missing
if not exist "public\storage" (
    echo Creating storage link...
    php artisan storage:link >nul 2>&1
    if not errorlevel 1 (
        echo Storage link created
    )
)

REM Choose port 8000 if free
netstat -an | findstr ":8000" >nul 2>&1
if not errorlevel 1 (
    echo Port 8000 is in use. Starting on automatic port.
    set PORT_OPTION=
) else (
    set PORT_OPTION=--port=8000
)

echo Starting Laravel development server...
php artisan serve %PORT_OPTION%

echo Server stopped
pause

