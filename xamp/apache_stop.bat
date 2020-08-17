@echo off
cd /D %~dp0
cmd.exe /C start "" /MIN call "C:\pannguyen\xamp\killprocess.bat" "httpd.exe"
if not exist apache\logs\httpd.pid GOTO exit
del apache\logs\httpd.pid

:exit
