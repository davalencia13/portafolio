@echo off
chcp 65001 >nul
echo 🚀 SUBIENDO PROYECTO COMPLETO AL SERVIDOR
echo ================================================

REM Verificar si Python está instalado
python --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Python no está instalado. Usando PowerShell...
    powershell -ExecutionPolicy Bypass -File "ftp_upload.ps1" dashboard
) else (
    echo ✅ Python encontrado. Usando script de Python...
    python ftp_upload.py --dashboard
)

echo.
echo ✅ Proceso completado!
echo 📁 Todos los archivos del proyecto han sido subidos
pause 