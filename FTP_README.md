# 📤 Scripts de Subida FTP - Portafolio Básico

## Descripción
Scripts automatizados para subir archivos al servidor FTP del portafolio básico.

## 📁 Archivos Creados

### Scripts Principales
- **`ftp_upload.py`** - Script en Python (Multiplataforma)
- **`ftp_upload.ps1`** - Script en PowerShell (Windows)
- **`subir_dashboard.bat`** - Archivo batch para ejecución rápida
- **`ftp_config.json`** - Configuración FTP

## 🚀 Cómo Usar

### Opción 1: Archivo Batch (Más Fácil - Windows)
```bash
# Doble clic en el archivo o ejecutar en cmd:
subir_dashboard.bat
```

### Opción 2: PowerShell (Windows)
```powershell
# Subir solo el dashboard
.\ftp_upload.ps1 dashboard

# Subir archivos específicos
.\ftp_upload.ps1 files index.php application/config/config.php

# Subir todo el directorio
.\ftp_upload.ps1

# Ver ayuda
.\ftp_upload.ps1 help
```

### Opción 3: Python (Multiplataforma)
```bash
# Subir solo el dashboard
python ftp_upload.py --dashboard

# Subir archivos específicos
python ftp_upload.py --files index.php application/config/config.php

# Subir todo el directorio
python ftp_upload.py

# Ver ayuda
python ftp_upload.py --help
```

## ⚙️ Configuración

### Datos de Conexión
Los datos están configurados en `ftp_config.json`:
```json
{
    "host": "15.235.119.22",
    "port": 21,
    "username": "portafo4",
    "password": "@q5S9jv;zS1LW7",
    "remotePath": "/public_html/"
}
```

### Modificar Configuración
1. Edita `ftp_config.json`
2. Cambia los valores según tu servidor
3. Los scripts leerán automáticamente la nueva configuración

## 📋 Funcionalidades

### ✅ Características Principales
- **Conexión segura** al servidor FTP
- **Subida de archivos específicos** o directorios completos
- **Creación automática de directorios** remotos
- **Exclusión de archivos** innecesarios (git, cache, etc.)
- **Resumen detallado** de la subida
- **Manejo de errores** robusto
- **Colores en consola** para mejor visualización

### 🎯 Opciones Específicas
- **Dashboard**: Sube solo los archivos del dashboard
- **Archivos específicos**: Sube solo los archivos que indiques
- **Directorio completo**: Sube todo el proyecto

## 🔧 Requisitos

### Para Python
```bash
# Python 3.6+ (incluido en el script)
# No requiere librerías adicionales (usa ftplib estándar)
```

### Para PowerShell
```powershell
# PowerShell 5.0+ (incluido en Windows 10/11)
# No requiere módulos adicionales
```

## 📊 Estructura de Archivos del Dashboard

Los archivos que se suben automáticamente son:
```
application/
├── controllers/
│   └── Dashboard.php
├── views/
│   ├── header.php
│   ├── footer.php
│   └── dashboard.php
└── config/
    └── routes.php
```

## 🛠️ Solución de Problemas

### Error de Conexión
```
❌ Error al conectar: [Errno 11001] getaddrinfo failed
```
**Solución**: Verifica que el host sea correcto en `ftp_config.json`

### Error de Autenticación
```
❌ Error al conectar: 530 Login incorrect
```
**Solución**: Verifica usuario y contraseña en `ftp_config.json`

### Error de Permisos (PowerShell)
```
❌ ExecutionPolicy error
```
**Solución**: Ejecuta como administrador o usa:
```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

### Archivos No Encontrados
```
⚠️ Archivo no encontrado: application/controllers/Dashboard.php
```
**Solución**: Verifica que estés en el directorio correcto del proyecto

## 🔒 Seguridad

### Recomendaciones
1. **No compartir** el archivo `ftp_config.json` con credenciales
2. **Usar variables de entorno** en producción
3. **Cambiar contraseñas** regularmente
4. **Usar SFTP** en lugar de FTP si es posible

### Variables de Entorno (Opcional)
Puedes usar variables de entorno en lugar de hardcodear credenciales:
```bash
# En Windows
set FTP_USERNAME=tu_usuario
set FTP_PASSWORD=tu_password

# En Linux/Mac
export FTP_USERNAME=tu_usuario
export FTP_PASSWORD=tu_password
```

## 📝 Logs y Resumen

### Ejemplo de Salida
```
🚀 SCRIPT DE SUBIDA FTP - PORTAFOLIO BÁSICO
==================================================
🔄 Conectando a 15.235.119.22:21...
✅ Conexión exitosa como portafo4
📁 Subiendo archivos del dashboard...
✅ Subido: application/controllers/Dashboard.php -> /public_html/application/controllers/Dashboard.php
✅ Subido: application/views/header.php -> /public_html/application/views/header.php
✅ Subido: application/views/footer.php -> /public_html/application/views/footer.php
✅ Subido: application/views/dashboard.php -> /public_html/application/views/dashboard.php
✅ Subido: application/config/routes.php -> /public_html/application/config/routes.php

==================================================
📊 RESUMEN DE LA SUBIDA
==================================================
✅ Archivos subidos exitosamente: 5
❌ Archivos con errores: 0

📋 Archivos subidos:
   ✅ application/controllers/Dashboard.php
   ✅ application/views/header.php
   ✅ application/views/footer.php
   ✅ application/views/dashboard.php
   ✅ application/config/routes.php
==================================================
🔌 Desconectado del servidor FTP
```

## 🎯 Próximos Pasos

1. **Probar la conexión** con el servidor
2. **Subir el dashboard** usando los scripts
3. **Verificar** que todo funcione correctamente
4. **Personalizar** la configuración según necesidades

## 📞 Soporte

Si tienes problemas:
1. Verifica la configuración en `ftp_config.json`
2. Revisa los logs de error
3. Asegúrate de estar en el directorio correcto
4. Verifica la conectividad al servidor 