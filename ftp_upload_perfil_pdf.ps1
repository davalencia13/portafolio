# Script de FTP para subir archivos del perfil de usuario con PDF
# Configuración FTP
$ftpServer = "ftp.portafolio4.com"
$ftpUsername = "portafo4_portafolio"
$ftpPassword = "Portafolio2024*"
$remotePath = "/public_html/"

# Archivos específicos del perfil a subir (solo PDF)
$filesToUpload = @(
    "application/controllers/C_Autentication.php",
    "application/models/Model_User.php",
    "application/views/view_perfil.php",
    "application/views/header.php",
    "application/config/routes.php"
)

# Función para subir archivo individual
function Upload-File {
    param($localFile, $remoteFile)
    
    try {
        $ftpUri = "ftp://$ftpServer$remotePath$remoteFile"
        $webClient = New-Object System.Net.WebClient
        $webClient.Credentials = New-Object System.Net.NetworkCredential($ftpUsername, $ftpPassword)
        
        Write-Host "Subiendo: $localFile -> $remoteFile" -ForegroundColor Green
        
        $webClient.UploadFile($ftpUri, $localFile)
        Write-Host "✓ Subido exitosamente: $remoteFile" -ForegroundColor Green
        
        $webClient.Dispose()
    }
    catch {
        Write-Host "✗ Error subiendo $localFile : $($_.Exception.Message)" -ForegroundColor Red
    }
}

# Función para crear directorio remoto
function Create-RemoteDirectory {
    param($directory)
    
    try {
        $ftpUri = "ftp://$ftpServer$remotePath$directory"
        $ftpRequest = [System.Net.FtpWebRequest]::Create($ftpUri)
        $ftpRequest.Credentials = New-Object System.Net.NetworkCredential($ftpUsername, $ftpPassword)
        $ftpRequest.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
        
        $response = $ftpRequest.GetResponse()
        Write-Host "✓ Directorio creado: $directory" -ForegroundColor Green
        $response.Close()
    }
    catch {
        # El directorio ya existe o no se puede crear
        Write-Host "ℹ Directorio ya existe o no se puede crear: $directory" -ForegroundColor Yellow
    }
}

# Crear directorios necesarios
Write-Host "Creando directorios remotos..." -ForegroundColor Cyan
Create-RemoteDirectory "application"
Create-RemoteDirectory "application/controllers"
Create-RemoteDirectory "application/models"
Create-RemoteDirectory "application/views"
Create-RemoteDirectory "application/config"

# Subir archivos
Write-Host "`nIniciando subida de archivos del perfil con PDF..." -ForegroundColor Cyan
$totalFiles = $filesToUpload.Count
$currentFile = 0

foreach ($file in $filesToUpload) {
    $currentFile++
    Write-Host "`nProgreso: $currentFile/$totalFiles" -ForegroundColor Yellow
    
    if (Test-Path $file) {
        Upload-File $file $file
    } else {
        Write-Host "✗ Archivo no encontrado: $file" -ForegroundColor Red
    }
}

Write-Host "`n✅ Subida del perfil con PDF completada!" -ForegroundColor Green
Write-Host "Total de archivos procesados: $totalFiles" -ForegroundColor Cyan
Write-Host "`n📋 El campo Pdf_file ya existe en tu tabla rol_users" -ForegroundColor Yellow 