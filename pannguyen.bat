@echo off

set countfiles=1000000000000000

:loop

set /a countfiles -= 1

cd c:/pannguyen 
C:
timeout /t 1
git pull
git add .
git commit -m "commit"
git push
timeout /t 1

if %countfiles% GTR 0 goto loop

pause