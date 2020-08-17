@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist C:\pannguyen\xamp\hypersonic\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\server\hsql-sample-database\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\ingres\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\ingres\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\mysql\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\mysql\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\postgresql\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\postgresql\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\apache\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\apache\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\openoffice\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\openoffice\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\apache-tomcat\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\apache-tomcat\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\resin\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\resin\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\jetty\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\jetty\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\subversion\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist C:\pannguyen\xamp\lucene\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\lucene\scripts\ctl.bat START)
if exist C:\pannguyen\xamp\third_application\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist C:\pannguyen\xamp\third_application\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\third_application\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\lucene\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist C:\pannguyen\xamp\subversion\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\subversion\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\jetty\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\jetty\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\hypersonic\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\resin\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\resin\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT C:\pannguyen\xamp\apache-tomcat\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\openoffice\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\openoffice\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\apache\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\apache\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\ingres\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\ingres\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\mysql\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\mysql\scripts\ctl.bat STOP)
if exist C:\pannguyen\xamp\postgresql\scripts\ctl.bat (start /MIN /B C:\pannguyen\xamp\postgresql\scripts\ctl.bat STOP)

:end

