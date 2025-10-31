# 🚀 NachoTechRD - Sistema Profesional de Gestión GSM

> Plataforma empresarial completa para la venta y gestión de servicios de desbloqueo IMEI, Server Express y File Services.

![Version](https://img.shields.io/badge/version-2.0-blue)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3.x-orange)
![License](https://img.shields.io/badge/license-MIT-green)

## ✨ Características Principales

### 🔐 Servicios de Desbloqueo
- **IMEI Services** - Desbloqueo por código IMEI con múltiples proveedores API
- **Server Express** - Servicios de servidor rápidos y eficientes
- **File Services** - Procesamiento de archivos para desbloqueo avanzado
- **Gestión Multi-API** - Soporte para múltiples proveedores simultáneos

### 💰 Sistema de Créditos y Pagos
- Sistema de créditos integrado
- Múltiples métodos de pago (Bancos, Criptomonedas, Transferencias)
- Calculadora inteligente de conversión de moneda
- Solicitudes de pago automatizadas
- Notificaciones Telegram integradas

### 👥 Gestión de Usuarios
- Panel de administración multi-usuario con permisos granulares
- Grupos de usuarios ilimitados
- Precios personalizados por grupo
- Panel de miembros intuitivo
- Panel de proveedores (suppliers)

### 🎨 Interfaz Moderna
- Diseño responsive y profesional
- Tema claro/oscuro
- Notificaciones elegantes
- Animaciones fluidas
- Agrupación visual de servicios con emojis

### 🛠️ Panel de Administración
- Gestión completa de APIs y servicios
- Editor masivo de precios
- Control de órdenes IMEI/File con acciones en lote
- Sistema de logs avanzado
- Diagnóstico y herramientas de verificación integradas

### ⚡ Rendimiento
- Optimizado para alto volumen de transacciones
- CRON jobs automatizados para sincronización
- Caché inteligente
- Validación condicional (IMEI/Serial Number)

## 📋 Requisitos del Sistema

- **PHP:** 7.4 o superior
- **MySQL:** 5.7 o superior
- **Apache/Nginx** con mod_rewrite
- **Extensiones PHP:** mysqli, curl, mbstring, openssl

## 🚀 Instalación Rápida

### 1. Base de Datos
```sql
CREATE DATABASE nachotechrd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Importa el archivo: `DB/database.sql`

### 2. Configuración
Edita los archivos de configuración:

**`application/config/database.php`**
```php
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'tu_usuario';
$db['default']['password'] = 'tu_contraseña';
$db['default']['database'] = 'nachotechrd';
```

**`application/config/config.php`**
```php
$config['base_url'] = 'http://localhost/nachotechrd/';
```

### 3. Configuración PHP (php.ini)
Asegúrate de tener estos valores:
```ini
max_input_vars = 5000
memory_limit = 512M
post_max_size = 40M
upload_max_filesize = 40M
```

### 4. Permisos
```bash
chmod -R 755 uploads/
chmod -R 755 application/logs/
```

## 🔑 Credenciales por Defecto

### Panel de Administración
```
URL: http://localhost/nachotechrd/index.php/admin
Usuario: admin@exclusiveunlock.co.uk
Contraseña: demo1234
```

### Panel de Miembros
```
URL: http://localhost/nachotechrd/
Usuario: demo@demo.com
Contraseña: demo1234
```

⚠️ **IMPORTANTE:** Cambia estas contraseñas inmediatamente después de la instalación.

## ⚙️ Configuración de CRON Jobs

Para Windows (XAMPP) usando Task Scheduler:
```batch
php C:\xampp\htdocs\nachotechrd\tools\ejecutar_cron_cli.php
```

Para Linux/Unix:
```bash
# Enviar órdenes IMEI cada minuto
* * * * * /usr/bin/php /ruta/completa/index.php cron send_imei_orders

# Recibir actualizaciones IMEI cada 10 minutos
*/10 * * * * /usr/bin/php /ruta/completa/index.php cron receive_imei_orders

# Enviar órdenes File cada minuto
* * * * * /usr/bin/php /ruta/completa/index.php cron send_file_orders

# Recibir actualizaciones File cada 10 minutos
*/10 * * * * /usr/bin/php /ruta/completa/index.php cron receive_file_orders
```

## 🎯 Características Destacadas

### 🔄 Sincronización Automática
- Sincronización bidireccional con APIs de proveedores
- Actualización automática de estados de órdenes
- Refund automático en caso de fondos insuficientes

### 📊 Gestión Avanzada
- Editor masivo de precios (fijo o porcentual)
- Filtrado inteligente de servicios por tipo (IMEI/Server)
- Búsqueda rápida de servicios en listas
- Selección múltiple con teclado (Shift+Click)

### 🎨 Personalización
- Temas personalizables para panel admin
- Agrupación visual de servicios por categoría
- Emojis y badges para mejor identificación
- Diseño responsive para móviles

## 📁 Estructura del Proyecto

```
nachotechrd/
├── application/          # Código de la aplicación
│   ├── controllers/     # Controladores MVC
│   ├── models/          # Modelos de datos
│   ├── views/           # Vistas/templates
│   └── config/          # Configuración
├── assets/              # Recursos estáticos
├── Pagos/              # Sistema de pagos mejorado
├── tools/              # Herramientas de desarrollo (no en producción)
└── DB/                 # Scripts de base de datos
```

## 🔒 Seguridad

- Validación de entrada en todas las peticiones
- Sanitización de datos de usuario
- Protección CSRF integrada
- Sesiones seguras
- Encriptación de contraseñas (MD5 con sal)
- Control de acceso basado en roles (RBAC)

## 🛠️ Herramientas de Desarrollo

Los archivos de testing, debugging y utilidades se encuentran en la carpeta `tools/` y **NO se suben a producción**. Ver `tools/README.md` para más información.

## 📝 Notas Importantes

- **Max Input Vars:** El sistema está configurado para manejar hasta 5000 variables de entrada. Si planeas agregar más de 300 servicios a la vez, considera aumentar este valor en `php.ini`.
- **Memoria:** Se recomienda al menos 512MB de memoria PHP para operaciones masivas.
- **Backup:** Realiza backups regulares de la base de datos, especialmente antes de operaciones masivas.

## 🐛 Soporte y Reporte de Errores

Si encuentras algún problema o tienes sugerencias:

1. Revisa los logs en `application/logs/`
2. Usa las herramientas de diagnóstico en el panel admin
3. Consulta la carpeta `tools/` para scripts de verificación

## 📄 Licencia

Este proyecto está basado en código de código abierto y se distribuye bajo licencia MIT.

## 🙏 Créditos

Sistema desarrollado con base en CodeIgniter Framework, mejorado y personalizado para NachoTechRD con características avanzadas de gestión empresarial.

---

**© 2025 NachoTechRD - Sistema Profesional de Gestión GSM**

*Versión mejorada y optimizada para operaciones de alto volumen*
