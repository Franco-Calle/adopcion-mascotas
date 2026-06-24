# Adopción de Mascotas

Plataforma web para gestionar la adopción de animales entre refugios y adoptantes, construida con Laravel + Tailwind CSS.

## Stack

- **Backend:** Laravel (PHP), MariaDB
- **Frontend:** Blade + Tailwind CSS + Vite
- **Imágenes:** Cloudinary
- **Auth:** Laravel Breeze
- **Docker:** MariaDB + App (Laravel) + Vite

## Roles

El sistema tiene tres roles de usuario (`role` en tabla `users`):

| Rol | Acceso |
|---|---|
| `admin` | Panel de administración — gestiona refugios |
| `refugio` | Panel del refugio — gestiona mascotas y postulaciones |
| `usuario` | Panel del adoptante — navega galería y envía postulaciones |

El middleware `CheckRole` (`app/Http/Middleware/CheckRole.php`) controla el acceso. La ruta `/dashboard` redirige según el rol.

## Modelos principales

- **`User`** — usuarios regulares y cuentas de refugio. Los refugios tienen campos extra (`telefono`, etc.) y poseen registros `Mascota` vía `refugio_id`.
- **`Mascota`** — aviso de mascota en adopción perteneciente a un refugio. Tiene muchas `FotoMascota` y `Postulacion`.
- **`FotoMascota`** — URLs de Cloudinary para fotos de la mascota, ordenadas por columna `orden`.
- **`Postulacion`** — solicitud de adopción de un `usuario` para una `Mascota`. El refugio gestiona el estado e incluye `comentario_admin`.

## Puesta en marcha

### Con Docker (recomendado)

#### 1. Copiar y configurar el `.env`

```bash
cp .env.example .env
```

Editar `.env` y ajustar la conexión a la base de datos (debe coincidir con `docker-compose.yml`) y las credenciales de Cloudinary:

```env
# Base de datos (valores del docker-compose.yml)
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=db_adopcion
DB_USERNAME=franco
DB_PASSWORD=password

# Cloudinary
CLOUDINARY_CLOUD_NAME=tu_cloud_name
CLOUDINARY_API_KEY=tu_api_key
CLOUDINARY_API_SECRET=tu_api_secret
```

#### 2. Levantar los contenedores

```bash
docker compose up -d
```

Inicia tres servicios y ejecuta automáticamente:
- `db` — MariaDB 10.11 en el puerto 3306 (con healthcheck)
- `app` — `composer install` → `php artisan key:generate` → servidor Laravel en el puerto 8000
- `vite` — `npm install` → Vite dev server en el puerto 5173

> El contenedor `app` espera a que la base de datos esté lista antes de arrancar gracias al healthcheck. `composer install` y `npm install` solo tardan en la primera ejecución; en las siguientes son instantáneos porque los volúmenes persisten.

#### 3. Migrar la base de datos

Una vez que los contenedores estén corriendo:

```bash
docker compose exec app php artisan migrate
```

#### 4. Poblar con datos (elegir una opción)

**Opción A — Seeders** (datos de prueba generados):
```bash
docker compose exec app php artisan db:seed
```

**Opción B — Dump SQL** (datos reales del proyecto):
```bash
docker exec -i db_adopcion_container mariadb -u franco -ppassword db_adopcion < db_adopcion.sql
```

#### Resumen (primera vez)

```bash
cp .env.example .env
# editar .env con las variables de DB y Cloudinary
docker compose up -d
# esperar ~30 segundos a que composer install y npm install terminen
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

La app queda disponible en `http://localhost:8000`.

---

### Sin Docker

```bash
composer run setup      # instala deps, copia .env, genera key, migra y compila assets
composer run dev        # servidor Laravel + queue + pail logger + Vite en paralelo
```

## Comandos útiles

```bash
# Desarrollo
php artisan serve           # servidor Laravel (puerto 8000)
npm run dev                 # Vite watcher

# Base de datos
php artisan migrate
php artisan db:seed
php artisan tinker

# Tests
composer run test                              # limpia cache y corre PHPUnit
php artisan test --filter TestClassName        # clase específica

# Estilo de código
./vendor/bin/pint                              # Laravel Pint (PHP CS Fixer)
```

## Notas

- Las fotos de mascotas se suben vía `UploadTrait` (`app/Traits/UploadTrait.php`) directamente a Cloudinary.
- El detalle de mascota usa un modal que consume `/api/mascota/{mascota}` como JSON.
- Las cuentas de refugio soportan soft deletes — ver ruta `admin/refugios/trashed` y la acción `restore`.
