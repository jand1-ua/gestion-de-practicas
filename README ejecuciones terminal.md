# README · Ejecuciones por sesión (comandos de terminal)

> Todos los comandos se ejecutan desde la **raíz del proyecto** (donde está `artisan`), salvo que se indique lo contrario.  
> Si acabas de clonar el repo, empieza por “Preparación común”.

---

## Preparación común (una sola vez)
### 1) Instalar dependencias PHP
```bash
composer install
```

### 3) Elegir base de datos (recomendado: MySQL)

#### Opción A · MySQL 
1) Crear BD y usuario (en MySQL):
```sql
CREATE DATABASE IF NOT EXISTS gestion_practicas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'laravel'@'localhost'
  IDENTIFIED BY 'laravel123';

GRANT ALL PRIVILEGES ON gestion_practicas.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
```

2) Configurar `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_practicas
DB_USERNAME=laravel
DB_PASSWORD=laravel123
```

### 4) Crear tablas y cargar datos de ejemplo
```bash
php artisan migrate:fresh --seed
```

### 5) Levantar servidor local
```bash
php artisan serve
```

---

# Sesión 1 · PHP (carpeta `sesion_1/`) — ejecución CLI
> Esta sesión NO usa Laravel (son scripts PHP sueltos).

```bash
php sesion_1/1-arrays/demo_listados.php
php sesion_1/2-poo/demo_poo.php
php sesion_1/3-namespaces/demo_namespaces.php
```

---

# Sesión 2 · Laravel básico (rutas “demo”, datos en memoria)
1) Levantar servidor:
```bash
php artisan serve
```

2) (Opcional) Ejecutar tests relacionados:
```bash
php artisan test --filter DemoPracticasControllerTest
php artisan test --filter PracticaDomainTest
```

Rutas para comprobar en navegador:
- `/demo/alumnos`
- `/demo/practicas`
- `/sesiones`

---

# Sesión 3 · Acceso a datos (Query Builder) + BD
1) Preparar BD (ver “Preparación común”) y cargar datos:
```bash
php artisan migrate:fresh --seed
```

2) Levantar servidor:
```bash
php artisan serve
```

Rutas para comprobar:
- `/db/alumnos`
- `/db/practicas`

---

# Sesión 4 · Eloquent ORM + relaciones
1) Cargar BD:
```bash
php artisan migrate:fresh --seed
```

2) Probar relaciones con tinker:
```bash
php artisan tinker
```

Dentro de tinker (una por línea):
```php
App\Models\Alumno::with('practicas')->first()->practicas;
App\Models\Empresa::with('tutores')->first()->tutores;
App\Models\Practica::with(['alumno','empresa','tutor'])->first();
```

3) (Opcional) Tests de relaciones:
```bash
php artisan test --filter EloquentPracticasTest
```

Rutas para comprobar:
- `/eloquent/alumnos`
- `/eloquent/practicas`

---

# Sesiones 5–7 · CRUD (zona coordinador)
1) Reset + seed:
```bash
php artisan migrate:fresh --seed
```

2) Servidor:
```bash
php artisan serve
```

3) Login (coordinador):
- Email: `coordinador@example.com`
- Password: `coordinador123`

Zona admin (CRUD):
- `/admin/alumnos`
- `/admin/empresas`
- `/admin/tutores`
- `/admin/practicas`

---

# Sesión 8 · Validación de formularios (FormRequest)
Tests de validación (CRUD admin):
```bash
php artisan test --filter AdminCrudTest
```

---

# Sesión 9 · Filtros + paginación en prácticas
1) Reset + seed:
```bash
php artisan migrate:fresh --seed
```

2) Test del filtro:
```bash
php artisan test --filter AdminCrudTest
```

Comprobación manual (logueado como coordinador):
- `/admin/practicas?estado=pendiente`

---

# Sesión 10 · Autenticación + roles + áreas privadas
1) Reset + seed (crea usuarios por rol):
```bash
php artisan migrate:fresh --seed
```

2) Servidor:
```bash
php artisan serve
```

Credenciales:
- Coordinador: `coordinador@example.com` / `coordinador123`
- Alumnos (seed):
  - `ana.garcia@example.com` / `alumno123`
  - `luis.perez@example.com` / `alumno123`
  - `maria.lopez@example.com` / `alumno123`
- Tutores (seed):
  - `carlos.ruiz@techsolutions.com` / `tutor123`
  - `elena.martinez@softedu.com` / `tutor123`

Tests de roles:
```bash
php artisan test --filter RolesTest
```

---

# Sesión 11 · Mensajería interna
1) Reset + seed:
```bash
php artisan migrate:fresh --seed
```

2) Servidor:
```bash
php artisan serve
```

Mensajes (requiere login):
- Listado: `/mensajes`
- Crear: `/mensajes/create`

---

## Ejecutar toda la batería de tests (en cualquier momento)
```bash
php artisan test
```