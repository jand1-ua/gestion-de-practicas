# PractUA · Plataforma de Gestión de Prácticas (Laravel)

Aplicación web desarrollada en **Laravel** para gestionar prácticas académicas: alta y administración de **alumnos**, **empresas** y **tutores**, asignación y seguimiento de **prácticas** por estado, y **mensajería interna** entre usuarios.

El repositorio recoge el desarrollo incremental del proyecto por sesiones (incluye rutas de demostración y ejemplos con BD) y una zona de administración con control de acceso por roles.

---

## Funcionalidades

- CRUD de **Alumnos**, **Empresas**, **Tutores** y **Prácticas**
- Relaciones:
  - Un **Alumno** puede tener varias **Prácticas**
  - Una **Empresa** puede tener varias **Prácticas** y varios **Tutores**
  - Un **Tutor** pertenece a una **Empresa**
- Estados de práctica (p. ej. `pendiente`, `en_curso`, etc.)
- Filtros y paginación en listados (especialmente prácticas)
- Autenticación (login/logout) y autorización por roles
- Áreas privadas por rol: alumno, tutor, coordinador
- Mensajería interna: bandeja, detalle y creación

---

## Requisitos

- PHP **8.2+**
- Composer
- Base de datos: **MySQL** (recomendado) o **SQLite**
- Servidor local: `php artisan serve`

---

# Guía de despliegue

## A) Despliegue local (desarrollo)

> Ejecuta estos pasos desde la **raíz del proyecto** (donde está el fichero `artisan`).

### 1) Instalar dependencias
```bash
composer install
```

### 2) Crear `.env` y generar la clave de la aplicación
```bash
cp .env.example .env
php artisan key:generate
```

### 3) Configurar base de datos

#### Opción A · MySQL (recomendada)
1) Crea la base de datos y un usuario con permisos (en MySQL):
```sql
CREATE DATABASE IF NOT EXISTS gestion_practicas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'laravel'@'localhost'
  IDENTIFIED BY 'laravel123';

GRANT ALL PRIVILEGES ON gestion_practicas.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
```

2) Configura tu `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_practicas
DB_USERNAME=laravel
DB_PASSWORD=laravel123
```

#### Opción B · SQLite (rápida)
1) Crea el fichero SQLite:
```bash
touch database/database.sqlite
```

2) Configura tu `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 4) Crear tablas y cargar datos de ejemplo
> Esto crea todas las tablas y carga usuarios/datos de prueba.

```bash
php artisan migrate:fresh --seed
```

### 5) Arrancar el servidor
```bash
php artisan serve
```

En el navegador:
- Inicio: `/`
- Login: `/login`
- Índice de sesiones: `/sesiones`

---

## Usuarios de ejemplo (seed)

Tras ejecutar `php artisan migrate:fresh --seed` se crean usuarios por rol.

### Coordinador
- Email: `coordinador@example.com`
- Password: `coordinador123`

### Alumnos
- `ana.garcia@example.com` / `alumno123`
- `luis.perez@example.com` / `alumno123`
- `maria.lopez@example.com` / `alumno123`

### Tutores
- `carlos.ruiz@techsolutions.com` / `tutor123`
- `elena.martinez@softedu.com` / `tutor123`

---

## Rutas principales

### Públicas
- `/` (inicio)
- `/login` (acceso)
- `/sesiones` (índice de ejemplos)
- `/demo/alumnos` y `/demo/practicas` (demo sin base de datos)

### Ejemplos con base de datos (sesiones)
- `/db/alumnos` y `/db/practicas` (Query Builder)
- `/eloquent/alumnos` y `/eloquent/practicas` (Eloquent)

### Panel coordinador (admin) — requiere rol coordinador
- `/admin/alumnos`
- `/admin/empresas`
- `/admin/tutores`
- `/admin/practicas`

### Áreas privadas por rol
- Alumno: `/area/alumno`
- Tutor: `/area/tutor`
- Coordinador: `/area/coordinador` (redirige al panel)

### Mensajería (requiere login)
- `/mensajes`
- `/mensajes/create`

---

## Tests

Ejecutar toda la suite:
```bash
php artisan test
```

Ejecutar por clase:
```bash
php artisan test --filter AdminCrudTest
php artisan test --filter RolesTest
php artisan test --filter DemoPracticasControllerTest
```

## Comandos por sesión (prácticas)

Para ver los comandos de terminal por sesión (ejecución y pruebas), consulta:
**`README ejecuciones terminal.md`**