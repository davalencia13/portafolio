# Script de subida FTP para Windows PowerShell
# Autor: Sistema de Dashboard
# Fecha: 2024

param(
    [Parameter(Position=0)]
    [string]$Action = "all",
    
    [Parameter(Position=1)]
    [string[]]$Files
)

# Configuración FTP
$FTPConfig = @{
    Host = "15.235.119.22"
    Port = 21
    Username = "portafo4"
    Password = "@q5S9jv;zS1LW7"
    RemotePath = "/public_html/"
}

# Variables globales
$UploadedFiles = @()
$FailedFiles = @()

function Write-ColorOutput {
    param(
        [string]$Message,
        [string]$Color = "White"
    )
    Write-Host $Message -ForegroundColor $Color
}

function Connect-FTP {
    try {
        Write-ColorOutput "🔄 Conectando a $($FTPConfig.Host):$($FTPConfig.Port)..." "Yellow"
        
        # Crear objeto FTP
        $ftp = New-Object System.Net.WebClient
        $ftp.Credentials = New-Object System.Net.NetworkCredential($FTPConfig.Username, $FTPConfig.Password)
        
        Write-ColorOutput "✅ Conexión exitosa como $($FTPConfig.Username)" "Green"
        return $ftp
    }
    catch {
        Write-ColorOutput "❌ Error al conectar: $($_.Exception.Message)" "Red"
        return $null
    }
}

function Upload-File {
    param(
        [string]$LocalFile,
        [System.Net.WebClient]$FtpClient
    )
    
    try {
        if (-not (Test-Path $LocalFile)) {
            Write-ColorOutput "⚠️  Archivo no encontrado: $LocalFile" "Yellow"
            $FailedFiles += @{File = $LocalFile; Error = "Archivo no encontrado"}
            return $false
        }
        
        # Construir la ruta remota
        $relativePath = $LocalFile.Replace((Get-Location).Path, "").TrimStart("\")
        $remotePath = $FTPConfig.RemotePath.TrimEnd("/") + "/" + $relativePath.Replace("\", "/")
        
        # Crear la URL FTP
        $ftpUrl = "ftp://$($FTPConfig.Host)$remotePath"
        
        # Subir el archivo
        $FtpClient.UploadFile($ftpUrl, $LocalFile)
        
        Write-ColorOutput "✅ Subido: $LocalFile -> $remotePath" "Green"
        $UploadedFiles += $LocalFile
        return $true
    }
    catch {
        Write-ColorOutput "❌ Error al subir $LocalFile : $($_.Exception.Message)" "Red"
        $FailedFiles += @{File = $LocalFile; Error = $_.Exception.Message}
        return $false
    }
}

function Upload-Directory {
    param(
        [string]$LocalDir = ".",
        [System.Net.WebClient]$FtpClient
    )
    
    Write-ColorOutput "📁 Iniciando subida del directorio: $LocalDir" "Cyan"
    Write-ColorOutput "🎯 Ruta remota: $($FTPConfig.RemotePath)" "Cyan"
    
    # Patrones de exclusión
    $excludePatterns = @(
        "__pycache__",
        ".git",
        ".vscode", 
        "node_modules",
        ".DS_Store",
        "Thumbs.db",
        "*.log",
        "*.tmp"
    )
    
    try {
        # Obtener todos los archivos recursivamente
        $allFiles = Get-ChildItem -Path $LocalDir -Recurse -File | Where-Object {
            $shouldInclude = $true
            foreach ($pattern in $excludePatterns) {
                if ($_.FullName -like "*$pattern*") {
                    $shouldInclude = $false
                    break
                }
            }
            return $shouldInclude
        }
        
        foreach ($file in $allFiles) {
            Upload-File -LocalFile $file.FullName -FtpClient $FtpClient
        }
    }
    catch {
        Write-ColorOutput "❌ Error durante la subida: $($_.Exception.Message)" "Red"
        return $false
    }
    
    return $true
}

function Upload-SpecificFiles {
    param(
        [string[]]$FileList,
        [System.Net.WebClient]$FtpClient
    )
    
    Write-ColorOutput "📁 Iniciando subida de $($FileList.Count) archivos específicos" "Cyan"
    
    foreach ($file in $FileList) {
        Upload-File -LocalFile $file -FtpClient $FtpClient
    }
}

function Upload-DashboardFiles {
    param(
        [System.Net.WebClient]$FtpClient
    )
    
    $dashboardFiles = @(
        # Archivos principales del sistema
        "index.php",
        ".htaccess",
        
        # Controladores
        "application/controllers/Dashboard.php",
        "application/controllers/Login.php",
        "application/controllers/C_Autentication.php",
        "application/controllers/C_Welcome.php",
        "application/controllers/Producto.php",
        
        # Vistas
        "application/views/header.php", 
        "application/views/footer.php",
        "application/views/dashboard.php",
        "application/views/view_login.php",
        "application/views/view_register.php",
        "application/views/view_landing.php",
        "application/views/view_producto.php",
        "application/views/welcome_message.php",
        
        # Modelos
        "application/models/Model_User.php",
        "application/models/Model_Loginuser.php",
        "application/models/M_Login.php",
        
        # Configuración
        "application/config/routes.php",
        "application/config/config.php",
        "application/config/database.php",
        "application/config/autoload.php",
        "application/config/constants.php",
        
        # Archivos de configuración del proyecto
        "composer.json",
        "readme.rst",
        "license.txt"
    )
    
    Write-ColorOutput "📁 Subiendo archivos completos del proyecto..." "Cyan"
    Upload-SpecificFiles -FileList $dashboardFiles -FtpClient $FtpClient
}

function Upload-Controllers {
    param(
        [System.Net.WebClient]$FtpClient
    )
    
    $controllerFiles = @(
        "application/controllers/Dashboard.php",
        "application/controllers/Login.php",
        "application/controllers/C_Autentication.php",
        "application/controllers/C_Welcome.php",
        "application/controllers/Producto.php"
    )
    
    Write-ColorOutput "📁 Subiendo controladores..." "Cyan"
    Upload-SpecificFiles -FileList $controllerFiles -FtpClient $FtpClient
}

function Upload-Views {
    param(
        [System.Net.WebClient]$FtpClient
    )
    
    $viewFiles = @(
        "application/views/header.php", 
        "application/views/footer.php",
        "application/views/dashboard.php",
        "application/views/view_login.php",
        "application/views/view_register.php",
        "application/views/view_landing.php",
        "application/views/view_producto.php",
        "application/views/welcome_message.php"
    )
    
    Write-ColorOutput "📁 Subiendo vistas..." "Cyan"
    Upload-SpecificFiles -FileList $viewFiles -FtpClient $FtpClient
}

function Upload-Models {
    param(
        [System.Net.WebClient]$FtpClient
    )
    
    $modelFiles = @(
        "application/models/Model_User.php",
        "application/models/Model_Loginuser.php",
        "application/models/M_Login.php"
    )
    
    Write-ColorOutput "📁 Subiendo modelos..." "Cyan"
    Upload-SpecificFiles -FileList $modelFiles -FtpClient $FtpClient
}

function Upload-Config {
    param(
        [System.Net.WebClient]$FtpClient
    )
    
    $configFiles = @(
        "application/config/routes.php",
        "application/config/config.php",
        "application/config/database.php",
        "application/config/autoload.php",
        "application/config/constants.php"
    )
    
    Write-ColorOutput "📁 Subiendo configuración..." "Cyan"
    Upload-SpecificFiles -FileList $configFiles -FtpClient $FtpClient
}

function Upload-Core {
    param(
        [System.Net.WebClient]$FtpClient
    )
    
    $coreFiles = @(
        "index.php",
        ".htaccess",
        "composer.json"
    )
    
    Write-ColorOutput "📁 Subiendo archivos principales..." "Cyan"
    Upload-SpecificFiles -FileList $coreFiles -FtpClient $FtpClient
}

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

function Show-Help {
    Write-ColorOutput @"
📖 AYUDA - SCRIPT DE SUBIDA FTP

Uso:
    .\ftp_upload.ps1                    # Subir todo el directorio
    .\ftp_upload.ps1 dashboard          # Subir archivos completos del proyecto
    .\ftp_upload.ps1 controllers        # Subir solo controladores
    .\ftp_upload.ps1 views              # Subir solo vistas
    .\ftp_upload.ps1 models             # Subir solo modelos
    .\ftp_upload.ps1 config             # Subir solo configuración
    .\ftp_upload.ps1 core               # Subir archivos principales
    .\ftp_upload.ps1 files arch1 arch2  # Subir archivos específicos
    .\ftp_upload.ps1 help               # Mostrar esta ayuda

Opciones:
    dashboard    Sube todos los archivos del proyecto (recomendado)
    controllers  Sube solo los controladores
    views        Sube solo las vistas
    models       Sube solo los modelos
    config       Sube solo la configuración
    core         Sube archivos principales (index.php, .htaccess, etc.)
    files        Sube archivos específicos (lista de archivos)
    help         Muestra esta ayuda

Ejemplos:
    .\ftp_upload.ps1 dashboard          # Subir todo el proyecto
    .\ftp_upload.ps1 controllers        # Solo controladores
    .\ftp_upload.ps1 views              # Solo vistas
    .\ftp_upload.ps1 files index.php application/config/config.php
    .\ftp_upload.ps1                    # Subir todo el directorio
"@ "Cyan"
}

# Función principal
function Main {
    Write-ColorOutput "🚀 SCRIPT DE SUBIDA FTP - PORTAFOLIO BÁSICO" "Magenta"
    Write-Host "=" * 50
    
    # Conectar al FTP
    $ftpClient = Connect-FTP
    if (-not $ftpClient) {
        return
    }
    
    try {
        switch ($Action.ToLower()) {
            "dashboard" {
                Upload-DashboardFiles -FtpClient $ftpClient
            }
            "controllers" {
                Upload-Controllers -FtpClient $ftpClient
            }
            "views" {
                Upload-Views -FtpClient $ftpClient
            }
            "models" {
                Upload-Models -FtpClient $ftpClient
            }
            "config" {
                Upload-Config -FtpClient $ftpClient
            }
            "core" {
                Upload-Core -FtpClient $ftpClient
            }
            "files" {
                if ($Files.Count -eq 0) {
                    Write-ColorOutput "❌ Debes especificar archivos para subir" "Red"
                    Write-ColorOutput "Uso: .\ftp_upload.ps1 files archivo1.php archivo2.php" "Yellow"
                    return
                }
                Upload-SpecificFiles -FileList $Files -FtpClient $ftpClient
            }
            "help" {
                Show-Help
                return
            }
            default {
                Write-ColorOutput "📁 Subiendo todo el directorio actual..." "Cyan"
                Upload-Directory -FtpClient $ftpClient
            }
        }
        
        # Mostrar resumen
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
}

# Ejecutar el script
Main 