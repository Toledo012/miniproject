# RAPH

RAPH es un mini sistema E-commerce desarrollado con Laravel 12 como base del **Mini Proyecto 2: Relaciones, Roles, Policies y Bitacoras en Laravel**. El proyecto fue reorganizado para cumplir con una estructura academica centrada en autenticacion manual, relaciones Eloquent reales, control de acceso por roles, autorizacion con Policies y Gates, validacion con FormRequest, poblamiento de datos con Seeders y Factories, y registro de eventos mediante canales de Log.

## Alcance del proyecto

El sistema permite:

- administrar productos;
- administrar categorias;
- registrar ventas;
- controlar accesos por rol;
- registrar eventos importantes en bitacoras;
- evidenciar relaciones entre modelos con Eloquent.

## Requerimientos cubiertos

La implementacion actual incluye:

- modelo `App\Models\Usuario` con autenticacion basada en `Authenticatable`;
- roles `administrador`, `gerente` y `cliente`;
- login manual con `Auth::attempt()` usando `correo` y `clave`;
- entidades `Usuario`, `Producto`, `Categoria` y `Venta`;
- relacion `Usuario 1:N Producto`;
- relacion `Producto N:N Categoria` mediante `categoria_producto`;
- relacion `Venta` con producto, cliente y vendedor;
- Policies para usuarios, productos, categorias y ventas;
- Gates para gestion de usuarios, catalogo y ventas;
- FormRequest para validacion de operaciones principales;
- Seeders y `UsuarioFactory`;
- bitacoras en `autenticacion.log`, `productos.log` y `ventas.log`;
- CRUD completo de productos, categorias y ventas;
- gestion de usuarios conforme a reglas de acceso por rol.

## Arquitectura funcional

### Modelo Usuario

El sistema ya no utiliza el modelo `User` por defecto de Laravel. La autenticacion se realiza con el modelo:

- `App\Models\Usuario`

Campos principales:

- `nombre`
- `apellidos`
- `correo`
- `clave`
- `rol`

El provider de autenticacion se encuentra configurado en:

- [`config/auth.php`](/C:/Laravel/miniproject/config/auth.php)

### Roles del sistema

- `administrador`
  - puede crear usuarios
  - puede editar usuarios
  - puede eliminar usuarios
- `gerente`
  - puede editar clientes
  - no puede editar gerentes
  - no puede editar administradores
- `cliente`
  - puede ver productos
  - puede registrar compras mediante ventas

### Entidades principales

- `Usuario`
- `Producto`
- `Categoria`
- `Venta`

### Relaciones implementadas

- `Usuario -> productos()`
- `Producto -> vendedor()`
- `Producto -> categorias()`
- `Categoria -> productos()`
- `Venta -> producto()`
- `Venta -> cliente()`
- `Venta -> vendedor()`
- `Usuario -> ventasComoCliente()`
- `Usuario -> ventasComoVendedor()`
- `Usuario -> categoriasPivot()` como acceso intermedio a categorias mediante productos

## Modulos principales

### Inicio publico

- pagina principal accesible sin autenticacion;
- informacion general del proyecto y de la marca;
- acceso a registro e inicio de sesion;
- muestra una seleccion reciente de productos.

### Autenticacion

- registro manual de cuentas cliente;
- inicio de sesion manual;
- cierre de sesion;
- redireccion al panel correspondiente segun el rol.

### Paneles

- panel de administrador con resumen de usuarios, productos, categorias y ventas;
- panel de gerente con control comercial, productos y ventas recientes;
- panel de cliente con historial de compras y productos sugeridos.

### Catalogo

- listado de productos;
- creacion de productos;
- edicion de productos;
- eliminacion de productos cuando no tienen ventas;
- asociacion de multiples categorias;
- detalle de producto con vendedor y categorias.

### Categorias

- listado de categorias;
- creacion de categorias;
- edicion de categorias;
- eliminacion de categorias;
- detalle de categoria mostrando productos relacionados.

### Ventas

- listado de ventas;
- registro de ventas;
- edicion de ventas;
- eliminacion de ventas;
- detalle de venta con producto, cliente y vendedor.

### Usuarios

- listado por tipo de cuenta;
- creacion de usuarios;
- edicion de usuarios;
- eliminacion de usuarios bajo reglas de proteccion.

## Autorizacion

La autorizacion del sistema esta basada en:

- `Policies`
- `Gates`

Archivos relevantes:

- [`app/Policies/UsuarioPolicy.php`](/C:/Laravel/miniproject/app/Policies/UsuarioPolicy.php)
- [`app/Policies/ProductoPolicy.php`](/C:/Laravel/miniproject/app/Policies/ProductoPolicy.php)
- [`app/Policies/CategoriaPolicy.php`](/C:/Laravel/miniproject/app/Policies/CategoriaPolicy.php)
- [`app/Policies/VentaPolicy.php`](/C:/Laravel/miniproject/app/Policies/VentaPolicy.php)
- [`app/Providers/AppServiceProvider.php`](/C:/Laravel/miniproject/app/Providers/AppServiceProvider.php)

## Validacion

La validacion de formularios se implementa mediante FormRequest, evitando validaciones directas dentro de controladores.

Ejemplos incluidos:

- [`app/Http/Requests/StoreProductoRequest.php`](/C:/Laravel/miniproject/app/Http/Requests/StoreProductoRequest.php)
- [`app/Http/Requests/UpdateProductoRequest.php`](/C:/Laravel/miniproject/app/Http/Requests/UpdateProductoRequest.php)
- [`app/Http/Requests/StoreCategoriaRequest.php`](/C:/Laravel/miniproject/app/Http/Requests/StoreCategoriaRequest.php)
- [`app/Http/Requests/UpdateCategoriaRequest.php`](/C:/Laravel/miniproject/app/Http/Requests/UpdateCategoriaRequest.php)
- [`app/Http/Requests/StoreVentaRequest.php`](/C:/Laravel/miniproject/app/Http/Requests/StoreVentaRequest.php)
- [`app/Http/Requests/UpdateVentaRequest.php`](/C:/Laravel/miniproject/app/Http/Requests/UpdateVentaRequest.php)
- [`app/Http/Requests/StoreUsuarioRequest.php`](/C:/Laravel/miniproject/app/Http/Requests/StoreUsuarioRequest.php)
- [`app/Http/Requests/UpdateUsuarioRequest.php`](/C:/Laravel/miniproject/app/Http/Requests/UpdateUsuarioRequest.php)

## Seeders y Factory

El proyecto incluye poblamiento inicial de datos para pruebas y evidencias.

### Factory obligatoria

- [`database/factories/UsuarioFactory.php`](/C:/Laravel/miniproject/database/factories/UsuarioFactory.php)

La factory genera usuarios usando:

- nombres: `Juan`, `Mario`, `Maria`, `Pedro`
- apellidos: `Lopez`, `Sanchez`, `Hernandez`, `Martinez`
- correo institucional con formato `inicial + apellido`
- clave fija `123` con hash
- rol aleatorio entre `cliente` y `gerente`

### Seeders principales

- [`database/seeders/UsuarioSeeder.php`](/C:/Laravel/miniproject/database/seeders/UsuarioSeeder.php)
- [`database/seeders/CategoriaSeeder.php`](/C:/Laravel/miniproject/database/seeders/CategoriaSeeder.php)
- [`database/seeders/ProductoSeeder.php`](/C:/Laravel/miniproject/database/seeders/ProductoSeeder.php)
- [`database/seeders/DatabaseSeeder.php`](/C:/Laravel/miniproject/database/seeders/DatabaseSeeder.php)

## Bitacoras del sistema

Se configuraron los siguientes canales:

- `storage/logs/autenticacion.log`
- `storage/logs/productos.log`
- `storage/logs/ventas.log`

Eventos registrados:

- `autenticacion.log`
  - login correcto
  - login incorrecto
  - logout
- `productos.log`
  - crear producto
  - editar producto
  - eliminar producto
- `ventas.log`
  - venta creada

Configuracion principal:

- [`config/logging.php`](/C:/Laravel/miniproject/config/logging.php)

## Rutas principales

Archivo principal:

- [`routes/web.php`](/C:/Laravel/miniproject/routes/web.php)

Rutas relevantes:

- `/`
- `/login`
- `/register`
- `/dashboard`
- `/panel/administrador`
- `/panel/gerente`
- `/panel/cliente`
- `/usuarios`
- `/productos`
- `/categorias`
- `/ventas`

## Instalacion

### Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL o MariaDB

### Pasos

1. Clonar el repositorio.

```bash
git clone <URL_DEL_REPOSITORIO>
cd miniproject
```

2. Instalar dependencias PHP.

```bash
composer install
```

3. Instalar dependencias de frontend.

```bash
npm install
```

4. Crear el archivo `.env` a partir de `.env.example`.

En Windows puedes copiarlo manualmente.

5. Configurar la conexion a base de datos en `.env`.

6. Generar la llave de la aplicacion.

```bash
php artisan key:generate
```

7. Ejecutar migraciones y seeders.

```bash
php artisan migrate:fresh --seed
```

8. Compilar assets.

```bash
npm run build
```

9. Levantar el servidor.

```bash
php artisan serve
```

## Desarrollo local

Para trabajar en modo desarrollo:

```bash
npm run dev
```

Y en otra terminal:

```bash
php artisan serve
```

## Credenciales de prueba

Despues de ejecutar:

```bash
php artisan migrate:fresh --seed
```

el sistema deja disponibles estas cuentas base:

- Administrador
  - correo: `admin@raph.local`
  - clave: `123`
- Gerente
  - correo: `gerente@raph.local`
  - clave: `123`
- Cliente
  - correo: `cliente@raph.local`
  - clave: `123`

Ademas, `UsuarioSeeder` y `UsuarioFactory` generan cuentas adicionales para pruebas.

## Como crear mas usuarios

### Desde el sistema

La forma principal es iniciar sesion con una cuenta administradora y acceder al modulo:

- `/usuarios`

Desde esa seccion se pueden crear nuevas cuentas indicando:

- nombre
- apellidos
- correo
- clave
- rol

### Desde seeders

Tambien puedes generar usuarios adicionales ejecutando:

```bash
php artisan migrate:fresh --seed
```

Esto recrea la base de datos y vuelve a cargar:

- usuarios de prueba
- categorias
- productos
- una venta inicial

## Tecnologias utilizadas

- PHP 8.2+
- Laravel 12
- Blade
- Tailwind CSS
- Alpine.js
- Vite
- MySQL

## Archivos clave para revision academica

- [`app/Models/Usuario.php`](/C:/Laravel/miniproject/app/Models/Usuario.php)
- [`app/Models/Producto.php`](/C:/Laravel/miniproject/app/Models/Producto.php)
- [`app/Models/Categoria.php`](/C:/Laravel/miniproject/app/Models/Categoria.php)
- [`app/Models/Venta.php`](/C:/Laravel/miniproject/app/Models/Venta.php)
- [`app/Http/Controllers/AutenticacionController.php`](/C:/Laravel/miniproject/app/Http/Controllers/AutenticacionController.php)
- [`app/Http/Controllers/ProductoController.php`](/C:/Laravel/miniproject/app/Http/Controllers/ProductoController.php)
- [`app/Http/Controllers/CategoriaController.php`](/C:/Laravel/miniproject/app/Http/Controllers/CategoriaController.php)
- [`app/Http/Controllers/VentaController.php`](/C:/Laravel/miniproject/app/Http/Controllers/VentaController.php)
- [`app/Http/Controllers/UsuarioController.php`](/C:/Laravel/miniproject/app/Http/Controllers/UsuarioController.php)
- [`config/auth.php`](/C:/Laravel/miniproject/config/auth.php)
- [`config/logging.php`](/C:/Laravel/miniproject/config/logging.php)
- [`routes/web.php`](/C:/Laravel/miniproject/routes/web.php)
- [`database/migrations`](/C:/Laravel/miniproject/database/migrations)
- [`database/seeders`](/C:/Laravel/miniproject/database/seeders)
- [`database/factories/UsuarioFactory.php`](/C:/Laravel/miniproject/database/factories/UsuarioFactory.php)

## Estado actual

El proyecto ya se encuentra alineado con los requerimientos del Mini Proyecto 2 en su parte funcional y tecnica:

- autenticacion manual;
- control de acceso por roles;
- relaciones Eloquent requeridas;
- CRUD de productos, categorias y ventas;
- policies y gates;
- FormRequest;
- seeders y factory;
- bitacoras por canal.

## Licencia

Proyecto desarrollado con fines academicos.
