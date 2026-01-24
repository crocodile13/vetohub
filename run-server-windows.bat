@echo off

REM Vérifie si PHP est dans le PATH
where php >nul 2>nul
IF %ERRORLEVEL% NEQ 0 (
    echo ❌ PHP n'est pas trouvé
    pause
    exit /b 1
)

echo 🚀 Serveur PHP démarré sur http://127.0.0.1:8088
echo    Appuyez sur Ctrl+C pour arrêter
php -S 127.0.0.1:8088
pause
