@echo off
REM Debugging: Print the current directory
echo Current directory: %cd%

REM Set the path to the directory of the batch file
set SCRIPT_DIR=%~dp0
echo Script directory: %SCRIPT_DIR%

REM Set the path to your PHP executable within the php folder in the current directory
set PHP_PATH=%SCRIPT_DIR%server\php.exe
echo PHP path: "%PHP_PATH%"

REM Check if PHP executable exists
if not exist "%PHP_PATH%" (
    echo PHP executable not found at "%PHP_PATH%"
    pause
    exit /b
)

REM Set the port number you want to use
set PORT=8000
echo Port: %PORT%

REM Change to the directory of the batch file
cd /d %SCRIPT_DIR%

REM Start the PHP built-in server
echo Starting PHP server...
"%PHP_PATH%" -S localhost:%PORT%

pause
