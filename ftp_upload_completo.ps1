# Script completo para subir archivos por FTP
param([string]$Action = "dashboard")

# Configuración FTP
$FTPHost = "15.235.119.22"
$Username = "portafo4"
$Password = "@q5S9jv;zS1LW7"
$RemotePath = "/public_html/"

# Variables globales
$UploadedFiles = @()
$FailedFiles = @()

function Write-ColorOutput {
    param([string]$Message, [string]$Color = "White")
    Write-Host $Message -ForegroundColor $Color
}

function Connect-FTP {
    try {
        Write-ColorOutput "🔄 Conectando a $FTPHost..." "Yellow"
        $ftp = New-Object System.Net.WebClient
        $ftp.Credentials = New-Object System.Net.NetworkCredential($Username, $Password)
        Write-ColorOutput "✅ Conexión exitosa como $Username" "Green"
        return $ftp
    }
    catch {
        Write-ColorOutput "❌ Error al conectar: $($_.Exception.Message)" "Red"
        return $null
    }
}

function Upload-File {
    param([string]$LocalFile, [System.Net.WebClient]$FtpClient)
    
    try {
        if (-not (Test-Path $LocalFile)) {
            Write-ColorOutput "⚠️ Archivo no encontrado: $LocalFile" "Yellow"
            $FailedFiles += @{File = $LocalFile; Error = "Archivo no encontrado"}
            return $false
        }
        
        $relativePath = $LocalFile.Replace((Get-Location).Path, "").TrimStart("\")
        $remotePath = $RemotePath.TrimEnd("/") + "/" + $relativePath.Replace("\", "/")
        $ftpUrl = "ftp://$FTPHost$remotePath"
        
        $FtpClient.UploadFile($ftpUrl, $LocalFile)
        Write-ColorOutput "✅ Subido: $LocalFile" "Green"
        $UploadedFiles += $LocalFile
        return $true
    }
    catch {
        Write-ColorOutput "❌ Error al subir $LocalFile : $($_.Exception.Message)" "Red"
        $FailedFiles += @{File = $LocalFile; Error = $_.Exception.Message}
        return $false
    }
}

function Upload-SpecificFiles {
    param([string[]]$FileList, [System.Net.WebClient]$FtpClient)
    
    Write-ColorOutput "📁 Subiendo $($FileList.Count) archivos..." "Cyan"
    foreach ($file in $FileList) {
        Upload-File -LocalFile $file -FtpClient $FtpClient
    }
}

function Upload-DashboardFiles {
    param([System.Net.WebClient]$FtpClient)
    
    $dashboardFiles = @(
        # Archivos principales
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
        
        # Archivos del proyecto
        "composer.json",
        "readme.rst",
        "license.txt"
    )
    
    Write-ColorOutput "📁 Subiendo archivos completos del proyecto..." "Cyan"
    Upload-SpecificFiles -FileList $dashboardFiles -FtpClient $FtpClient
}

function Upload-Controllers {
    param([System.Net.WebClient]$FtpClient)
    
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
    param([System.Net.WebClient]$FtpClient)
    
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
    param([System.Net.WebClient]$FtpClient)
    
    $modelFiles = @(
        "application/models/Model_User.php",
        "application/models/Model_Loginuser.php",
        "application/models/M_Login.php"
    )
    
    Write-ColorOutput "📁 Subiendo modelos..." "Cyan"
    Upload-SpecificFiles -FileList $modelFiles -FtpClient $FtpClient
}

function Upload-Config {
    param([System.Net.WebClient]$FtpClient)
    
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
    .\ftp_upload_completo.ps1 dashboard    # Subir archivos completos del proyecto
    .\ftp_upload_completo.ps1 controllers  # Subir solo controladores
    .\ftp_upload_completo.ps1 views        # Subir solo vistas
    .\ftp_upload_completo.ps1 models       # Subir solo modelos
    .\ftp_upload_completo.ps1 config       # Subir solo configuración
    .\ftp_upload_completo.ps1 help         # Mostrar esta ayuda

Opciones:
    dashboard    Sube todos los archivos del proyecto (recomendado)
    controllers  Sube solo los controladores
    views        Sube solo las vistas
    models       Sube solo los modelos
    config       Sube solo la configuración
    help         Muestra esta ayuda

Ejemplos:
    .\ftp_upload_completo.ps1 dashboard
    .\ftp_upload_completo.ps1 controllers
    .\ftp_upload_completo.ps1 views
"@ "Cyan"
}

# Función principal
Write-ColorOutput "🚀 SCRIPT DE SUBIDA FTP - PORTAFOLIO BÁSICO" "Magenta"
Write-Host "=" * 50

$ftpClient = Connect-FTP
if (-not $ftpClient) {
    exit
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
        "help" {
            Show-Help
            exit
        }
        default {
            Write-ColorOutput "📁 Subiendo archivos completos del proyecto..." "Cyan"
            Upload-DashboardFiles -FtpClient $ftpClient
        }
    }
    
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