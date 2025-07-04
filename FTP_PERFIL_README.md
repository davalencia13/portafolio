# Scripts FTP para Subir Archivo de Perfil

## 📋 Descripción
Scripts para subir el archivo `view_perfil.php` al servidor FTP con todas las correcciones implementadas.

## 🗂️ Archivos Creados

### 1. Script PowerShell Completo
- **Archivo**: `ftp_upload_perfil_completo.ps1`
- **Descripción**: Script PowerShell avanzado con colores, validaciones y resumen detallado
- **Características**:
  - ✅ Conexión segura FTP
  - ✅ Validación de archivos
  - ✅ Manejo de errores
  - ✅ Resumen detallado
  - ✅ Colores en la salida
  - ✅ Creación automática de directorios

### 2. Comandos FTP Simples
- **Archivo**: `ftp_perfil_simple_commands.txt`
- **Descripción**: Archivo de comandos FTP básico para subida rápida
- **Características**:
  - ✅ Comandos FTP nativos
  - ✅ Subida directa
  - ✅ Sin dependencias adicionales

## 🚀 Cómo Usar

### Opción 1: Script PowerShell (Recomendado)

```powershell
# Ejecutar el script PowerShell
powershell -ExecutionPolicy Bypass -File ftp_upload_perfil_completo.ps1
```

**Ventajas**:
- Interfaz colorida y profesional
- Validaciones automáticas
- Resumen detallado de la subida
- Manejo de errores robusto

### Opción 2: Comandos FTP Nativos

```cmd
# Ejecutar comandos FTP
ftp -s:ftp_perfil_simple_commands.txt
```

**Ventajas**:
- No requiere PowerShell
- Subida rápida y directa
- Compatible con cualquier sistema Windows

## 📁 Archivo a Subir

- **Archivo**: `application/views/view_perfil.php`
- **Descripción**: Vista del perfil de usuario con todas las correcciones
- **Características**:
  - ✅ Validaciones `isset()` para evitar errores
  - ✅ Referencias corregidas a minúsculas (`image`, `pdf_file`)
  - ✅ Sin referencias a `cv_file` o `Image` con mayúscula
  - ✅ Interfaz moderna con Bootstrap 5
  - ✅ Subida de imágenes y PDF

## 🔧 Configuración FTP

```powershell
# Configuración del servidor
$ftpServer = "ftp.portafolio4.com"
$ftpUsername = "portafo4_portafolio"
$ftpPassword = "Portafolio2024*"
$remotePath = "/public_html/"
```

## 📊 Estructura de Directorios

```
public_html/
└── application/
    └── views/
        └── view_perfil.php  # Archivo a subir
```

## ✅ Verificación Post-Subida

Después de subir el archivo, verificar:

1. **Acceder al perfil**: `http://tu-dominio.com/perfil`
2. **Verificar que no hay errores**: Revisar consola del navegador
3. **Probar funcionalidades**:
   - Subir imagen de perfil
   - Subir documento PDF
   - Ver archivos existentes
   - Editar información personal

## 🎯 Características del Archivo Subido

### Funcionalidades Implementadas
- ✅ Formulario de edición de perfil
- ✅ Subida de imagen de perfil (JPG, PNG, GIF - 2MB)
- ✅ Subida de documento PDF (5MB máximo)
- ✅ Cambio de contraseña opcional
- ✅ Validaciones de seguridad
- ✅ Interfaz responsive

### Correcciones Aplicadas
- ✅ Validaciones `isset()` para evitar errores
- ✅ Referencias a campos en minúsculas
- ✅ Eliminación de código innecesario
- ✅ Manejo robusto de archivos

## 🚨 Solución de Problemas

### Error de Conexión FTP
```powershell
# Verificar conectividad
ping ftp.portafolio4.com
```

### Error de Permisos
```powershell
# Ejecutar como administrador si es necesario
Start-Process powershell -Verb RunAs
```

### Error de Archivo No Encontrado
```powershell
# Verificar que el archivo existe
Test-Path "application/views/view_perfil.php"
```

## 📝 Notas Importantes

1. **Backup**: Siempre hacer backup antes de subir
2. **Verificación**: Probar la funcionalidad después de subir
3. **Caché**: Limpiar caché del navegador si es necesario
4. **Logs**: Revisar logs de error si hay problemas

## 🎉 Resultado Esperado

Después de ejecutar el script exitosamente:

- ✅ Archivo subido al servidor
- ✅ Sin errores de propiedades indefinidas
- ✅ Funcionalidad completa del perfil
- ✅ Interfaz moderna y funcional 