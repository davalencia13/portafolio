# Sistema de Perfil de Usuario - CodeIgniter

## 📋 Descripción
Sistema completo para la gestión del perfil de usuario en CodeIgniter, que permite a los usuarios ver y editar su información personal, incluyendo foto de perfil.

## 🗂️ Archivos Implementados

### Controladores
- **`application/controllers/C_Autentication.php`**
  - Método `perfil()`: Maneja la visualización y actualización del perfil
  - Validación de formularios
  - Subida de imágenes
  - Actualización de datos del usuario

### Modelos
- **`application/models/Model_User.php`**
  - `get_user_by_id($user_id)`: Obtiene usuario por ID
  - `update_user($user_id, $data)`: Actualiza datos del usuario
  - `check_username_exists()`: Verifica si el nombre de usuario existe
  - `check_email_exists()`: Verifica si el email existe

### Vistas
- **`application/views/view_perfil.php`**
  - Formulario moderno con Bootstrap 5
  - Campos para todos los datos del usuario
  - Subida de imagen de perfil
  - Cambio de contraseña opcional
  - Vista previa del perfil actual

### Configuración
- **`application/config/routes.php`**
  - Ruta: `perfil` → `C_Autentication/perfil`

### Navegación
- **`application/views/header.php`**
  - Enlace "Mi Perfil" en el menú principal
  - Dropdown con opciones de usuario
  - Enlace "Editar Perfil" en el menú de usuario

## 🗄️ Estructura de Base de Datos

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
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
```

## ✨ Características Implementadas

### 🔐 Seguridad
- Verificación de sesión activa
- Validación de formularios
- Encriptación de contraseñas con BCRYPT
- Verificación de tipos de archivo para imágenes

### 📝 Formulario de Perfil
- **Campos obligatorios:**
  - Nombre completo
  - Nombre de usuario
- **Campos opcionales:**
  - Email
  - Teléfono
  - Edad
  - Foto de perfil
  - Nueva contraseña

### 🖼️ Gestión de Imágenes
- Subida de imágenes (JPG, PNG, GIF)
- Límite de 2MB por archivo
- Eliminación automática de imagen anterior
- Vista previa de imagen actual

### 🎨 Interfaz de Usuario
- Diseño responsive con Bootstrap 5
- Iconos de Font Awesome
- Gradientes y efectos visuales
- Mensajes de éxito y error
- Validación en tiempo real

## 🚀 Cómo Usar

### Acceso al Perfil
1. Iniciar sesión en el sistema
2. Hacer clic en "Mi Perfil" en el menú principal
3. O hacer clic en el avatar de usuario → "Editar Perfil"

### Editar Información
1. Modificar los campos deseados
2. Opcionalmente subir una nueva foto
3. Opcionalmente cambiar la contraseña
4. Hacer clic en "Guardar Cambios"

### Navegación
- **Dashboard**: Volver al panel principal
- **Cerrar Sesión**: Salir del sistema

## 📁 Estructura de Archivos

```
application/
├── controllers/
│   └── C_Autentication.php (método perfil)
├── models/
│   └── Model_User.php (métodos de usuario)
├── views/
│   ├── view_perfil.php (vista del perfil)
│   └── header.php (navegación actualizada)
└── config/
    └── routes.php (ruta del perfil)

uploads/ (carpeta para imágenes de perfil)
```

## 🔧 Configuración Requerida

### Permisos de Carpeta
- La carpeta `uploads/` debe tener permisos de escritura
- Recomendado: 755 para la carpeta

### Configuración de PHP
- Extensión `fileinfo` habilitada
- Límite de subida de archivos configurado
- Memoria suficiente para procesar imágenes

## 📊 Validaciones Implementadas

### Campos de Texto
- **Nombre**: 2-100 caracteres, obligatorio
- **Usuario**: 3-100 caracteres, obligatorio
- **Email**: Formato válido, máximo 100 caracteres
- **Teléfono**: Máximo 65 caracteres

### Campos Numéricos
- **Edad**: 1-120 años, numérico

### Contraseña
- **Nueva contraseña**: 6-20 caracteres
- **Confirmación**: Debe coincidir con nueva contraseña

### Imágenes
- **Tipos permitidos**: JPG, PNG, GIF
- **Tamaño máximo**: 2MB
- **Nombre único**: Generado automáticamente

## 🎯 Funcionalidades Futuras

- [ ] Validación de email único
- [ ] Validación de nombre de usuario único
- [ ] Recorte de imágenes
- [ ] Historial de cambios
- [ ] Exportación de datos del perfil
- [ ] Integración con redes sociales

## 📞 Soporte

Para cualquier problema o consulta sobre el sistema de perfil, revisar:
1. Logs de error de CodeIgniter
2. Permisos de carpeta `uploads/`
3. Configuración de base de datos
4. Configuración de PHP para subida de archivos 