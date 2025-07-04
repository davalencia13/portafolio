# Script simplificado para subir dashboard por FTP
param([string]$Action = "dashboard")

# Configuración FTP
$Host = "15.235.119.22"
$Username = "portafo4"
$Password = "@q5S9jv;zS1LW7"
$RemotePath = "/public_html/"

Write-Host "🚀 SUBIENDO DASHBOARD AL SERVIDOR FTP" -ForegroundColor Magenta
Write-Host "================================================" -ForegroundColor Magenta

# Archivos del dashboard
$dashboardFiles = @(
    "application/controllers/Dashboard.php",
    "application/controllers/Login.php",
    "application/views/header.php",
    "application/views/footer.php", 
    "application/views/dashboard.php",
    "application/config/routes.php"
)

# Crear cliente FTP
$ftp = New-Object System.Net.WebClient
$ftp.Credentials = New-Object System.Net.NetworkCredential($Username, $Password)

$uploadedCount = 0
$failedCount = 0

try {
    Write-Host "🔄 Conectando al servidor FTP..." -ForegroundColor Yellow
    
    foreach ($file in $dashboardFiles) {
        if (Test-Path $file) {
            try {
                # Construir URL FTP
                $remoteFile = $RemotePath.TrimEnd("/") + "/" + $file.Replace("\", "/")
                $ftpUrl = "ftp://$Host$remoteFile"
                
                # Subir archivo
                $ftp.UploadFile($ftpUrl, $file)
                
                Write-Host "✅ Subido: $file" -ForegroundColor Green
                $uploadedCount++
            }
            catch {
                Write-Host "❌ Error al subir $file : $($_.Exception.Message)" -ForegroundColor Red
                $failedCount++
            }
        }
        else {
            Write-Host "⚠️ Archivo no encontrado: $file" -ForegroundColor Yellow
            $failedCount++
        }
    }
}
catch {
    Write-Host "❌ Error de conexión: $($_.Exception.Message)" -ForegroundColor Red
}
finally {
    $ftp.Dispose()
    Write-Host "🔌 Desconectado del servidor FTP" -ForegroundColor Yellow
}

# Resumen
Write-Host ""
Write-Host "================================================" -ForegroundColor Magenta
Write-Host "📊 RESUMEN DE LA SUBIDA" -ForegroundColor Magenta
Write-Host "================================================" -ForegroundColor Magenta
Write-Host "✅ Archivos subidos exitosamente: $uploadedCount" -ForegroundColor Green
Write-Host "❌ Archivos con errores: $failedCount" -ForegroundColor Red
Write-Host "================================================" -ForegroundColor Magenta

if ($uploadedCount -gt 0) {
    Write-Host "🎉 ¡Dashboard y Login subidos exitosamente!" -ForegroundColor Green
} 