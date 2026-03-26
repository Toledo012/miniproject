# RAPH

RAPH es un e-commerce desarrollado con Laravel 12 para la gestión de catálogo, compras y operación interna. El proyecto fue construido como parte de una entrega académica y organiza la experiencia del sistema según el tipo de cuenta que inicia sesión.

## Descripción general

La aplicación incluye:

- Página de inicio pública con información institucional.
- Registro e inicio de sesión.
- Redirección automática después del login según el tipo de cuenta.
- Espacios de trabajo diferenciados para compra, operación e información administrativa.
- CRUD de usuarios.
- Gestión de contenido del inicio.
- Gestión de inventario.
- Carrito de compra y generación de pedidos.
- Seguimiento y actualización del estado de pedidos.

## Objetivo del proyecto

Construir una base funcional de tienda en línea que permita:

- mostrar una página principal accesible para cualquier visitante;
- registrar usuarios y autenticar accesos;
- dirigir cada cuenta al flujo que le corresponde;
- evidenciar la administración de usuarios mediante un CRUD;
- demostrar una base escalable para futuras entregas del e-commerce.

## Funcionalidades principales

### Inicio público

- Vista principal accesible sin autenticación.
- Secciones editables como:
  - Quiénes somos
  - Misión
  - Visión
  - Ubicación
  - Contacto
- Accesos a iniciar sesión y registrarse.

### Autenticación

- Formulario de inicio de sesión.
- Formulario de registro.
- Validación de credenciales y datos de registro.
- Cierre de sesión.
- Recuperación y restablecimiento de contraseña con Breeze.

### Flujo después del inicio de sesión

- Cuentas de compra:
  - dashboard personal;
  - catálogo;
  - carrito;
  - historial de pedidos.
- Cuentas operativas:
  - tablero con métricas;
  - gestión de inventario;
  - revisión de solicitudes de compra.
- Cuentas administrativas:
  - resumen general;
  - gestión de usuarios;
  - edición del contenido del inicio;
  - acceso al inventario y pedidos.

### Gestión de usuarios

El sistema incluye un CRUD de usuarios con:

- listado por tipo de cuenta;
- creación de nuevas cuentas;
- edición de información y acceso;
- eliminación con reglas de protección.

Reglas relevantes:

- no se puede eliminar la propia cuenta desde el panel de usuarios;
- no se puede eliminar el último gerente;
- no se elimina un usuario con historial de pedidos;
- la contraseña solo se actualiza si se captura una nueva y su confirmación.

### Catálogo e inventario

- Alta de productos.
- Edición de productos.
- Eliminación o desactivación lógica cuando existe historial relacionado.
- Imagen opcional por producto.
- Búsqueda de productos para el flujo de compra.

### Carrito y pedidos

- Agregar productos al carrito.
- Actualizar cantidades.
- Eliminar productos del carrito.
- Generar pedido desde checkout.
- Seguimiento de estado del pedido.

## Tecnologías utilizadas

- PHP 8.2+
- Laravel 12
- Laravel Breeze
- Blade
- Tailwind CSS
- Alpine.js
- Vite
- MySQL

## Estructura funcional del proyecto

### Controladores principales

- `InicioController`: página principal.
- `AuthenticatedSessionController`: login y redirección posterior.
- `RegisteredUserController`: registro de usuarios.
- `PanelClienteController`: dashboard de compra.
- `PanelEmpleadoController`: tablero operativo.
- `PanelGerenteController`: tablero administrativo.
- `GestionEmpleadosController`: CRUD de usuarios.
- `ProductoController`: catálogo e inventario.
- `CarritoController`: carrito y checkout.
- `PedidoController`: historial de pedidos.
- `SolicitudCompraController`: gestión de estados de pedidos.
- `ContenidoSitioController`: edición del contenido del inicio.

### Rutas importantes

- `/` inicio público.
- `/login` inicio de sesión.
- `/register` registro.
- `/dashboard` redirección según cuenta.
- `/cliente/*` flujo de compra.
- `/empleado/*` operación interna.
- `/gerente/*` administración.
- `/inventario/products` inventario.

## Requisitos previos

Antes de ejecutar el proyecto, asegúrate de contar con:

- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL o MariaDB

## Instalación

1. Clonar el repositorio:

```bash
git clone <URL_DEL_REPOSITORIO>
cd miniproject
```

2. Instalar dependencias de backend:

```bash
composer install
```

3. Instalar dependencias de frontend:

```bash
npm install
```

4. Crear el archivo de entorno:

```bash
cp .env.example .env
```

En Windows puedes copiar manualmente `.env.example` como `.env`.

5. Configurar la conexión a base de datos en `.env`.

6. Generar la llave de aplicación:

```bash
php artisan key:generate
```

7. Ejecutar migraciones y seeders:

```bash
php artisan migrate --seed
```

8. Compilar assets:

```bash
npm run build
```

9. Iniciar el servidor:

```bash
php artisan serve
```

## Entorno de desarrollo

Para trabajar en desarrollo con Vite:

```bash
npm run dev
```

Y en otra terminal:

```bash
php artisan serve
```

También puedes usar el script de Composer:

```bash
composer run dev
```

## Credenciales de prueba

Al ejecutar `php artisan migrate --seed`, se generan estas cuentas demo:

- Gerencia
  - correo: `gerente@tienda.local`
  - contraseña: `password`
- Compra
  - correo: `cliente@tienda.local`
  - contraseña: `password`
- Operación
  - correo: `empleado@tienda.local`
  - contraseña: `password`

## Validaciones relevantes

- Registro:
  - nombre obligatorio;
  - correo obligatorio y único;
  - contraseña obligatoria con confirmación.
- Login:
  - correo y contraseña obligatorios;
  - control de intentos mediante rate limiting.
- Usuarios:
  - nombre, correo y tipo de cuenta obligatorios;
  - datos de contacto opcionales;
  - contraseña opcional en edición.
- Checkout:
  - la dirección debe existir en el perfil para poder generar el pedido.

## Base de datos

El proyecto incluye migraciones para:

- usuarios;
- sesiones y recuperación de contraseña;
- productos;
- carrito;
- pedidos;
- detalle de pedidos;
- contenido del sitio.

## Estado actual del proyecto

Actualmente el sistema ya cubre los puntos esenciales de la entrega:

- inicio público;
- autenticación;
- validación de login y registro;
- redirección después del login;
- paneles principales;
- CRUD de usuarios;
- listado de usuarios;
- vistas Blade necesarias para el flujo principal;
- operación base de un e-commerce académico funcional.

## Posibles mejoras futuras

- pasarela de pago real;
- filtros avanzados de catálogo;
- panel de reportes con estadísticas más profundas;
- carga de imágenes optimizada;
- pruebas automatizadas más amplias;
- mejora continua de UX en vistas secundarias.

## Licencia

Este proyecto fue desarrollado con fines académicos y de aprendizaje.
