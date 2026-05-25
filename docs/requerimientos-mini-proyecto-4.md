# Requerimientos Mini Proyecto 4

Fuente: `C:/Users/MASACRE/Downloads/fibdd.docx`

## Estado general

| Requisito | Estado | Evidencia actual | Siguiente accion |
| --- | --- | --- | --- |
| Repositorio GitHub publico | Cumplido | `https://github.com/Toledo012/miniproject.git` | Confirmar visibilidad publica desde GitHub |
| Commits descriptivos | Cumplido | `origin/main` contiene commits como `Configuracion inicial del pipeline`, `Pruebas automaticas login`, `Configuracion despliegue cloud`, `Correccion pipeline CI` | Tomar captura del historial |
| Minimo 5 commits significativos | Cumplido | `origin/main` tiene mas de 5 commits significativos | Incluir evidencia en reporte |
| Pipeline CI con GitHub Actions | Cumplido | `.github/workflows/laravel.yml` | Tomar captura de ejecucion |
| CI en push y pull request hacia `main` | Cumplido | Workflow configura `push` y `pull_request` contra `main` | Verificar corrida remota exitosa |
| Instalar PHP en pipeline | Cumplido | `shivammathur/setup-php@v2` con PHP 8.2 | Incluir fragmento en reporte |
| Instalar dependencias Composer | Cumplido | `composer install --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-scripts` | Incluir fragmento en reporte |
| Configurar entorno de pruebas | Cumplido | Copia `.env.example` a `.env.testing` y genera `APP_KEY` | Incluir fragmento en reporte |
| SQLite para pruebas | Cumplido | `phpunit.xml` usa SQLite `:memory:` y workflow prepara SQLite | Incluir fragmento en reporte |
| Ejecutar migraciones y seeders | Cumplido | Workflow ejecuta `php artisan migrate --force` y `php artisan db:seed --force` | Incluir fragmento en reporte |
| Ejecutar pruebas automaticas | Cumplido | `composer test` pasa localmente: 10 tests, 31 assertions | Incluir salida/captura |
| Minimo 6 pruebas automaticas reales | Cumplido | Hay 10 pruebas Feature, incluyendo login, autorizacion, catalogo y ventas | Explicar que valida cada prueba |
| No limitar pruebas a status 200 | Cumplido | Tests validan autenticacion, autorizacion y persistencia en BD | Incluir archivos `tests/Feature/*` |
| Variables de entorno fuera del repo | Cumplido | `.gitignore` ignora `.env`; `.env.example` no trae secretos | Mostrar `.gitignore` y `.env.example` |
| README con descripcion, tecnologias e instalacion | Cumplido parcial | `README.md` contiene descripcion, stack, instalacion local, pruebas y CI | Agregar URL publica cuando exista |
| URL publica del sistema | Pendiente | No hay URL de produccion registrada en el repo | Desplegar y actualizar README/reporte |
| Despliegue cloud sin Railway | Pendiente | Hay `Dockerfile`, pero falta evidencia de plataforma y URL | Elegir plataforma cloud y configurar variables |
| CD automatico desde GitHub | Pendiente opcional | No se confirma deploy automatico desde GitHub | Implementar si se busca hasta 100 |
| Reporte PDF con evidencias | Pendiente | Aun no existe reporte en el repo | Crear reporte con capturas y explicaciones |

## Pruebas locales

Comando ejecutado:

```bash
composer test
```

Resultado despues de configurar `APP_KEY` para testing en `phpunit.xml`:

```text
Tests: 10 warnings (31 assertions)
Duration: 1.12s
```

Las warnings locales se deben a que no existe un archivo `.env` local. En el pipeline, el workflow crea `.env.testing`, por lo que el CI deberia correr sin ese ruido.

## Archivos clave para mostrar

- `.github/workflows/laravel.yml`
- `phpunit.xml`
- `tests/Feature/AuthTest.php`
- `tests/Feature/AutorizacionTest.php`
- `tests/Feature/HomeTest.php`
- `tests/Feature/PublicRoutesTest.php`
- `tests/Feature/VentasTest.php`
- `README.md`
- `.env.example`
- `.gitignore`
- `Dockerfile`

## Pendientes antes de entrega

1. Confirmar que GitHub Actions termina en verde en `main`.
2. Elegir plataforma cloud distinta de Railway.
3. Configurar variables de entorno en la plataforma cloud.
4. Desplegar la aplicacion y obtener URL publica.
5. Actualizar `README.md` con la URL publica y detalles de deploy.
6. Preparar reporte PDF con capturas de repositorio, commits, pipeline, tests, deploy y variables.
