# miniproyecto

E-commerce con gestión de usuarios por rol, autenticación en dos pasos (2FA por
correo) y flujo de validación de compras. Diseñado con una estética editorial
neutra (paleta hueso / negro / champagne) sobre un backend Laravel.

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?logo=sqlite&logoColor=white)
![CI](https://github.com/Toledo012/miniproject/actions/workflows/laravel.yml/badge.svg)

---

## Descripción del sistema

Plataforma web de comercio electrónico que organiza a sus usuarios en cuatro
roles con permisos diferenciados y aplica autorización fina mediante Policies
de Laravel:

| Rol          | Capacidades principales                                                   |
| ------------ | ------------------------------------------------------------------------- |
| **Admin**    | Acceso al panel administrativo, gestión total de usuarios, productos y categorías. |
| **Gerente**  | Valida o rechaza ventas pendientes, supervisa productos y categorías.     |
| **Vendedor** | Publica y administra sus propios artículos, consulta sus ventas.          |
| **Comprador**| Explora el catálogo, realiza compras y adjunta comprobante de pago.       |

**Flujo de venta (estados):** `pendiente → validada` / `rechazada`. El comprador
sube un comprobante de pago al confirmar; un gerente revisa el ticket y aprueba
o rechaza la operación. Las notificaciones se envían por correo (vendedor y
comprador) y el stock se decrementa únicamente cuando la venta queda validada.

**Autenticación en dos pasos:** todo login emite un código OTP de 6 dígitos por
correo (vigencia 5 min). Las cuentas con dominio `@demo.test` están exentas de
2FA para facilitar pruebas locales y CI.

---

## Tecnologías

| Capa                   | Stack                                                   |
| ---------------------- | ------------------------------------------------------- |
| **Lenguaje**           | PHP 8.2                                                 |
| **Framework**          | Laravel 12                                              |
| **Base de datos**      | SQLite (desarrollo y pruebas), MySQL/MariaDB (producción opcional) |
| **Frontend**           | Blade + Vite, tipografía Inter + Playfair Display       |
| **Mail**               | SMTP (Gmail en dev) / `log` (testing)                   |
| **Testing**            | PHPUnit 11 sobre SQLite `:memory:`                      |
| **CI/CD**              | GitHub Actions (`.github/workflows/laravel.yml`)        |
| **Herramientas**       | Composer 2, npm, `php artisan storage:link`             |

---

## Instalación local

### Requisitos previos

- PHP **8.2+** con las extensiones `pdo_sqlite`, `mbstring`, `gd`, `fileinfo`,
  `bcmath`, `intl`, `curl`, `xml`.
- Composer 2.
- (Opcional) Node 18+ y npm si se quiere recompilar assets con Vite.

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/Toledo012/miniproject.git
cd miniproject

# 2. Instalar dependencias PHP
composer install

# 3. Copiar el archivo de entorno y generar la APP_KEY
cp .env.example .env
php artisan key:generate

# 4. Crear la base SQLite local
mkdir -p database
touch database/database.sqlite

# 5. Ajustar el .env para SQLite local
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite

# 6. Ejecutar migraciones y seeders (datos demo)
php artisan migrate --seed

# 7. Crear las cuentas demo (idempotente)
php artisan db:seed --class=CuentasDemoSeeder

# 8. Crear el symlink de storage (para imágenes públicas)
php artisan storage:link

# 9. (Opcional) Compilar assets
npm install
npm run build

# 10. Levantar el servidor
php artisan serve
```

La app queda disponible en `http://localhost:8000`.

### Cuentas demo (bypass de 2FA, contraseña `password`)

| Rol       | Email                  |
| --------- | ---------------------- |
| Admin     | `admin@demo.test`      |
| Gerente   | `gerente@demo.test`    |
| Vendedor  | `vendedor@demo.test`   |
| Comprador | `comprador@demo.test`  |

---

## Ejecución de pruebas

Las pruebas usan **SQLite en memoria** (configurado con `force="true"` en
`phpunit.xml` para que ignore variables del sistema):

```bash
# Suite completa
php artisan test

# Solo Feature tests
php artisan test --testsuite=Feature

# Un archivo específico
php artisan test tests/Feature/AuthTest.php

# Un test concreto
php artisan test --filter test_login_correcto_autentica_usuario
```

### Cobertura actual

| Archivo                                  | Pruebas |
| ---------------------------------------- | ------- |
| `tests/Feature/HomeTest.php`             | Página principal con catálogo                 |
| `tests/Feature/PublicRoutesTest.php`     | Rutas públicas `/` y `/login` (HTTP 200)      |
| `tests/Feature/AuthTest.php`             | Login OK / KO, dashboard protegido            |
| `tests/Feature/AutorizacionTest.php`     | Admin crea categoría, vendedor crea producto, comprador sin acceso |
| `tests/Feature/VentasTest.php`           | Registro de venta con ticket y total correcto |

> **Tip:** el helper `TestCase::imagenFake()` genera un PNG 1×1 válido
> embebido en base64; permite correr la suite **sin** la extensión GD.

---

## Integración continua (GitHub Actions)

El workflow [`/.github/workflows/laravel.yml`](.github/workflows/laravel.yml) se
ejecuta en cada `push` y `pull_request` contra `main`:

1. Clona el repositorio.
2. Instala PHP 8.2 con extensiones (`shivammathur/setup-php@v2`).
3. Restaura cache de Composer.
4. `composer install --optimize-autoloader`.
5. Copia `.env.example` a `.env.testing` y genera `APP_KEY`.
6. Crea un archivo SQLite y ejecuta `php artisan migrate --force`.
7. Ejecuta `php artisan db:seed --force`.
8. Lanza `php artisan test` contra **SQLite en memoria**.

Estado actual del pipeline:
👉 https://github.com/Toledo012/miniproject/actions

---

## Estructura del proyecto

```
app/
├── Http/Controllers/        # Auth, Catalogo, Productos, Categorías, Users, Ventas, Dashboard
├── Http/Requests/           # FormRequests para validación
├── Mail/                    # Mailables (2FA, ventas validadas/rechazadas)
├── Models/                  # User, Producto, Categoria, Venta, Foto, CodigoVerificacion
├── Policies/                # CategoriaPolicy, ProductoPolicy, VentaPolicy, UserPolicy
└── Services/                # TwoFactorService, VentaService, ProductoService, DashboardService

database/
├── factories/               # UserFactory (admin/gerente/vendedor/comprador), Categoria, Producto
├── migrations/              # Esquema del dominio
└── seeders/                 # DatabaseSeeder, CuentasDemoSeeder, ProductoSeeder, etc.

resources/views/             # Blade con paleta neutra (auth split-screen, CRUDs, catálogo)
routes/web.php               # Rutas públicas + grupos protegidos por rol
tests/Feature/               # Pruebas funcionales (HTTP end-to-end)
tests/Unit/                  # Pruebas unitarias
```

---

## Licencia

Proyecto académico — uso interno.
