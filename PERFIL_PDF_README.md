# Sistema de Perfil de Usuario con PDF - CodeIgniter

## 📋 Descripción
Sistema completo para la gestión del perfil de usuario en CodeIgniter, que permite a los usuarios ver y editar su información personal, incluyendo foto de perfil y documentos PDF.

## 🆕 Funcionalidad Agregada

### 📄 Subida de Archivos PDF
- **Documento PDF**: Campo para subir archivos PDF (máximo 5MB)
- **Validación de formato**: Solo archivos PDF permitidos
- **Control de tamaño**: Límite de 5MB por archivo
- **Eliminación automática**: Archivos anteriores se eliminan al subir nuevos

## 🗂️ Archivos Modificados

### Controladores
- **`application/controllers/C_Autentication.php`**
  - Agregado procesamiento de subida de PDF
  - Validación de tipo de archivo PDF
  - Control de tamaño de archivos
  - Eliminación automática de archivos anteriores

### Vistas
- **`application/views/view_perfil.php`**
  - Campo para subir PDF
  - Enlace para ver archivo actual
  - Información sobre tipo de archivo permitido
  - Vista previa de archivo existente

## 🗄️ Estructura de Base de Datos

El sistema utiliza el campo `Pdf_file` que ya existe en tu tabla `rol_users`:

```sql
CREATE TABLE `rol_users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT 'Full name',
  `phone` varchar(65) DEFAULT NULL,
  `user` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Pdf_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
```

## ✨ Características del Archivo PDF

### 📄 Documento PDF
- **Tipos permitidos**: Solo PDF
- **Tamaño máximo**: 5MB
- **Ubicación**: Carpeta `uploads/`
- **Nomenclatura**: `pdf_[user_id]_[timestamp].pdf`

### 🖼️ Foto de Perfil (existente)
- **Tipos permitidos**: JPG, PNG, GIF
- **Tamaño máximo**: 2MB
- **Ubicación**: Carpeta `uploads/`
- **Nomenclatura**: `user_[user_id]_[timestamp].[extension]`

## 🔧 Configuración Requerida

### Permisos de Servidor
- Carpeta `uploads/` con permisos de escritura (755)
- Configuración de PHP para subida de archivos:
  ```php
  upload_max_filesize = 10M
  post_max_size = 10M
  max_execution_time = 300
  ```

### Configuración de CodeIgniter
- Biblioteca de upload habilitada en `autoload.php` o cargada manualmente
- Configuración de tipos MIME para archivos PDF

## 🎨 Interfaz de Usuario

### Formulario de Perfil
- **Campo PDF**: Input file con validación de tipo PDF
- **Vista previa**: Enlace para ver archivo actual
- **Información**: Texto explicativo sobre tipo y tamaño permitido

### Tarjeta de Información
- **Documento PDF**: Icono rojo con enlace de descarga
- **Información actualizada**: Detalles sobre tipo de archivo permitido

## 🚀 Cómo Usar

### Subir Archivo PDF
1. Acceder al perfil de usuario
2. Hacer clic en "Elegir archivo" en el campo PDF
3. Seleccionar archivo PDF
4. Guardar cambios

### Ver Archivo PDF
1. En el perfil, hacer clic en "Ver PDF Actual"
2. El archivo se abre en una nueva pestaña
3. Opción de descarga directa

### Eliminar Archivo PDF
1. Subir un nuevo archivo PDF
2. El archivo anterior se elimina automáticamente
3. No hay opción manual de eliminación

## 📊 Validaciones Implementadas

### Archivos PDF
- **Tipo**: Solo archivos .pdf
- **Tamaño**: Máximo 5MB
- **Nombre**: Generado automáticamente
- **Seguridad**: Verificación de tipo MIME

## 🔐 Seguridad

### Validación de Archivos
- Verificación de extensión de archivo
- Verificación de tipo MIME
- Control de tamaño máximo
- Nombres de archivo únicos y seguros

### Gestión de Archivos
- Eliminación automática de archivos anteriores
- Verificación de existencia antes de eliminar
- Manejo de errores en subida de archivos

## 📁 Estructura de Archivos

```
application/
├── controllers/
│   └── C_Autentication.php (procesamiento de PDF)
├── views/
│   └── view_perfil.php (campo de archivo PDF agregado)
└── config/
    └── routes.php (sin cambios)

uploads/ (carpeta para todos los archivos)
├── user_[id]_[timestamp].jpg (fotos de perfil)
└── pdf_[id]_[timestamp].pdf (documentos PDF)
```

## 🎯 Funcionalidades Futuras

- [ ] Vista previa de PDF en el navegador
- [ ] Compresión automática de archivos grandes
- [ ] Historial de archivos subidos
- [ ] Categorización de documentos
- [ ] Búsqueda en contenido de PDF
- [ ] Firma digital de documentos

## 📞 Soporte

Para problemas con la subida de archivos:
1. Verificar permisos de carpeta `uploads/`
2. Revisar configuración de PHP para subida de archivos
3. Verificar que el campo `Pdf_file` existe en la tabla `rol_users`
4. Revisar logs de error de CodeIgniter

## ⚠️ Notas Importantes

1. **El campo `Pdf_file` ya existe** en tu tabla `rol_users`
2. **Verificar permisos** de la carpeta uploads
3. **Configurar PHP** para archivos de hasta 5MB
4. **Solo archivos PDF** son permitidos 