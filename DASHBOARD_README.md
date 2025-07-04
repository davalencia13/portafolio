# Dashboard - Sistema de Gestión

## Descripción
Se ha creado un dashboard moderno y funcional para el sistema de gestión con las siguientes características:

### Archivos Creados

#### 1. Vistas (`application/views/`)
- **`header.php`** - Cabecera común con navegación y información del usuario
- **`footer.php`** - Pie de página con información del sistema y scripts
- **`dashboard.php`** - Vista principal del dashboard con estadísticas y widgets

#### 2. Controlador (`application/controllers/`)
- **`Dashboard.php`** - Controlador que maneja la lógica del dashboard

#### 3. Rutas (`application/config/routes.php`)
- Se agregaron las rutas necesarias para el dashboard

## Características del Dashboard

### 🎨 Diseño Moderno
- Interfaz responsive con Bootstrap 5
- Iconos de Font Awesome
- Colores consistentes y profesionales
- Navegación intuitiva

### 📊 Widgets y Estadísticas
- **Tarjetas de estadísticas** con:
  - Usuarios activos
  - Total de productos
  - Ventas mensuales
  - Pedidos pendientes

### 📈 Gráficos (Preparados para implementación)
- Área para gráfico de actividad reciente
- Gráfico de dona para distribución de ventas
- Preparado para integración con Chart.js

### 📋 Tablas y Listas
- Tabla de últimos usuarios registrados
- Lista de actividad del sistema en tiempo real

### 🔐 Seguridad
- Verificación de sesión de usuario
- Redirección automática si no está autenticado
- Información del usuario en la cabecera

## Cómo Usar

### 1. Acceso al Dashboard
```
URL: http://tu-dominio/dashboard
```

### 2. Navegación
- **Logo**: Lleva al dashboard principal
- **Inicio**: Dashboard principal
- **Productos**: Gestión de productos
- **Usuarios**: Gestión de usuarios (preparado)
- **Reportes**: Reportes del sistema (preparado)

### 3. Funcionalidades AJAX (Preparadas)
- `/dashboard/stats` - Obtener estadísticas
- `/dashboard/activity` - Obtener actividad reciente

## Personalización

### Cambiar Colores
Los colores están definidos en CSS personalizado en `header.php`:
```css
.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
```

### Agregar Nuevos Widgets
1. Crear el HTML en `dashboard.php`
2. Agregar la lógica en el controlador `Dashboard.php`
3. Actualizar las rutas si es necesario

### Integrar con Base de Datos
Para conectar con datos reales:
1. Crear modelos para obtener datos
2. Modificar los métodos en `Dashboard.php`
3. Actualizar las vistas para mostrar datos dinámicos

## Estructura de Archivos
```
application/
├── controllers/
│   └── Dashboard.php
├── views/
│   ├── header.php
│   ├── footer.php
│   └── dashboard.php
└── config/
    └── routes.php (actualizado)
```

## Próximos Pasos Sugeridos

1. **Integrar Chart.js** para gráficos dinámicos
2. **Conectar con base de datos** para datos reales
3. **Agregar filtros** por fecha y categoría
4. **Implementar notificaciones** en tiempo real
5. **Crear reportes** exportables (PDF, Excel)

## Notas Técnicas

- Compatible con CodeIgniter 3.x
- Requiere Bootstrap 5 y Font Awesome
- Responsive design para móviles y tablets
- Preparado para escalabilidad 