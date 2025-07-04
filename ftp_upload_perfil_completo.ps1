# Script de FTP para subir archivo view_perfil.php
# Configuración FTP
$ftpServer = "ftp.portafolio4.com"
$ftpUsername = "portafo4_portafolio"
$ftpPassword = "Portafolio2024*"
$remotePath = "/public_html/"

# Función para escribir texto con colores
function Write-ColorOutput {
    param(
        [string]$Message,
        [string]$Color = "White"
    )
    
    switch ($Color.ToLower()) {
        "red" { Write-Host $Message -ForegroundColor Red }
        "green" { Write-Host $Message -ForegroundColor Green }
        "yellow" { Write-Host $Message -ForegroundColor Yellow }
        "blue" { Write-Host $Message -ForegroundColor Blue }
        "magenta" { Write-Host $Message -ForegroundColor Magenta }
        "cyan" { Write-Host $Message -ForegroundColor Cyan }
        default { Write-Host $Message -ForegroundColor White }
    }
}

# Función para conectar al FTP
function Connect-FTP {
    try {
        Write-ColorOutput "🔌 Conectando al servidor FTP..." "Cyan"
        
        $ftpUri = "ftp://$ftpServer"
        $webClient = New-Object System.Net.WebClient
        $webClient.Credentials = New-Object System.Net.NetworkCredential($ftpUsername, $ftpPassword)
        
        # Probar conexión
        $webClient.DownloadString($ftpUri) | Out-Null
        
        Write-ColorOutput "✅ Conexión FTP establecida exitosamente" "Green"
        return $webClient
    }
    catch {
        Write-ColorOutput "❌ Error al conectar al FTP: $($_.Exception.Message)" "Red"
        return $null
    }
}

# Variables globales para seguimiento
$script:UploadedFiles = @()
$script:FailedFiles = @()

# Función para subir archivo individual
function Upload-File {
    param(
        [string]$LocalFile,
        [string]$RemoteFile,
        [System.Net.WebClient]$FtpClient
    )
    
    try {
        if (-not (Test-Path $LocalFile)) {
            throw "Archivo local no encontrado: $LocalFile"
        }
        
        $ftpUri = "ftp://$ftpServer$remotePath$RemoteFile"
        
        Write-ColorOutput "📤 Subiendo: $LocalFile -> $RemoteFile" "Yellow"
        
        $FtpClient.UploadFile($ftpUri, $LocalFile)
        
        Write-ColorOutput "✅ Subido exitosamente: $RemoteFile" "Green"
        $script:UploadedFiles += $LocalFile
    }
    catch {
        Write-ColorOutput "❌ Error subiendo $LocalFile : $($_.Exception.Message)" "Red"
        $script:FailedFiles += @{
            File = $LocalFile
            Error = $_.Exception.Message
        }
    }
}

# Función para crear directorio remoto
function Create-RemoteDirectory {
    param(
        [string]$Directory,
        [System.Net.WebClient]$FtpClient
    )
    
    try {
        $ftpUri = "ftp://$ftpServer$remotePath$Directory"
        $ftpRequest = [System.Net.FtpWebRequest]::Create($ftpUri)
        $ftpRequest.Credentials = New-Object System.Net.NetworkCredential($ftpUsername, $ftpPassword)
        $ftpRequest.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
        
        $response = $ftpRequest.GetResponse()
        Write-ColorOutput "📁 Directorio creado: $Directory" "Green"
        $response.Close()
    }
    catch {
        # El directorio ya existe o no se puede crear
        Write-ColorOutput "ℹ Directorio ya existe: $Directory" "Yellow"
    }
}

# Función para subir archivo de perfil
function Upload-PerfilFile {
    param([System.Net.WebClient]$FtpClient)
    
    $perfilFile = "application/views/view_perfil.php"
    
    Write-ColorOutput "📁 Subiendo archivo de perfil..." "Cyan"
    Upload-File -LocalFile $perfilFile -RemoteFile $perfilFile -FtpClient $FtpClient
}

# Función para mostrar resumen
function Show-Summary {
    Write-Host ""
    Write-Host "=" * 50
    Write-ColorOutput "📊 RESUMEN DE LA SUBIDA" "Magenta"
    Write-Host "=" * 50
    Write-ColorOutput "✅ Archivos subidos exitosamente: $($UploadedFiles.Count)" "Green"
    Write-ColorOutput "❌ Archivos con errores: $($FailedFiles.Count)" "Red"
    
    if ($UploadedFiles.Count -gt 0) {
        Write-ColorOutput "`n📋 Archivos subidos:" "Cyan"
        foreach ($file in $UploadedFiles) {
            Write-ColorOutput "   ✅ $file" "Green"
        }
    }
    
    if ($FailedFiles.Count -gt 0) {
        Write-ColorOutput "`n❌ Archivos con errores:" "Red"
        foreach ($failed in $FailedFiles) {
            Write-ColorOutput "   ❌ $($failed.File): $($failed.Error)" "Red"
        }
    }
    
    Write-Host "=" * 50
}

# Función para mostrar ayuda
function Show-Help {
    Write-ColorOutput @"
📖 AYUDA - SCRIPT DE SUBIDA FTP PARA PERFIL

Uso:
    .\ftp_upload_perfil_completo.ps1    # Subir archivo view_perfil.php

Descripción:
    Este script sube el archivo view_perfil.php al servidor FTP
    con todas las correcciones y validaciones implementadas.

Archivos incluidos:
    - application/views/view_perfil.php (archivo principal del perfil)

Características:
    - Conexión segura FTP
    - Validación de archivos
    - Manejo de errores
    - Resumen detallado
    - Colores en la salida

Ejemplo:
    .\ftp_upload_perfil_completo.ps1
"@ "Cyan"
}

# Función principal
Write-ColorOutput "🚀 SCRIPT DE SUBIDA FTP - ARCHIVO DE PERFIL" "Magenta"
Write-Host "=" * 50

$ftpClient = Connect-FTP
if (-not $ftpClient) {
    exit
}

try {
    # Crear directorios necesarios
    Write-ColorOutput "📁 Creando directorios remotos..." "Cyan"
    Create-RemoteDirectory "application" -FtpClient $ftpClient
    Create-RemoteDirectory "application/views" -FtpClient $ftpClient
    
    # Subir archivo de perfil
    Upload-PerfilFile -FtpClient $ftpClient
    
    Show-Summary
}
catch {
    Write-ColorOutput "❌ Error general: $($_.Exception.Message)" "Red"
}
finally {
    if ($ftpClient) {
        $ftpClient.Dispose()
        Write-ColorOutput "🔌 Desconectado del servidor FTP" "Yellow"
    }
} 