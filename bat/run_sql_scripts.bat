@echo off
setlocal enabledelayedexpansion

:: Prompt for MySQL credentials and port
set /p HOST=Enter MySQL Host:
set /p USERNAME=Enter MySQL Username:
set /p PASSWORD=Enter MySQL Password:
set /p PORT=Enter MySQL Port (default 3306):

if "%PORT%"=="" (
set PORT=3306
)

:: Get the directory of this script
SET SCRIPT_DIR=%~dp0

echo Script directory: %SCRIPT_DIR%

:: Set log and SQL directories relative to the script directory
set LOG_FILE=%SCRIPT_DIR%..\logs\MySQL_logs.log
set SQL_DIR=%SCRIPT_DIR%..\sql

:: Create the log directory if it does not exist
if not exist "%SCRIPT_DIR%..\logs" (
mkdir "%SCRIPT_DIR%..\logs"
)

:: Attempt to connect to the MySQL server
echo %PASSWORD% | mysql -h %HOST% -u %USERNAME% -P %PORT% -e "exit"
if errorlevel 1 (
echo Connection failed. Please check your credentials and try again.
goto :EOF
) else (
echo Connection successful!
)

:: Function-like call to execute a SQL file
:: Since batch does not support functions the same way, we create a subroutine.
:execute_mysql
:: %1 is the full path to the SQL file.
echo Executing %~nx1...
echo Executing %~nx1... >> "%LOG_FILE%"
:: Execute SQL file and append both stdout and stderr to log file.
echo %PASSWORD% | mysql -h %HOST% -u %USERNAME% -P %PORT% < "%~1" >> "%LOG_FILE%" 2>&1
if errorlevel 1 (
echo Failed to execute %~nx1.
) else (
echo SQL file executed successfully.
)
goto :eof

:: Execute all SQL scripts in the defined order.
:: Note: Adjust the file names if necessary.
echo Creating database... >> "%LOG_FILE%"
call :execute_mysql "%SQL_DIR%\create_database.sql"

echo Creating tables... >> "%LOG_FILE%"
call :execute_mysql "%SQL_DIR%\create_tables.sql"

echo Creating triggers... >> "%LOG_FILE%"
call :execute_mysql "%SQL_DIR%\create_triggers.sql"

echo Creating functions... >> "%LOG_FILE%"
call :execute_mysql "%SQL_DIR%\create_functions.sql"

echo Creating procedures... >> "%LOG_FILE%"
call :execute_mysql "%SQL_DIR%\create_procedures.sql"

echo Creating views... >> "%LOG_FILE%"
call :execute_mysql "%SQL_DIR%\create_views.sql"

echo Inserting data... >> "%LOG_FILE%"
call :execute_mysql "%SQL_DIR%\insert_data.sql"

echo All operations completed.
pause
