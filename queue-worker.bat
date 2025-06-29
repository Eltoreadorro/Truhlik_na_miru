@echo off
:loop
php artisan queue:work --tries=3 --timeout=30
timeout /t 1 > nul
goto loop
