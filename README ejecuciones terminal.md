Iteración 1 (carpeta sesion_1):

-> probar código de 1-arrays: 

php sesion_1/1-arrays/demo_listados.php

-> Probar código de 2-poo:

php sesion_1/2-poo/demo_poo.php

-> Probar código de 3-namespaces:

php sesion_1/3-namespaces/demo_namespaces.php

--------------------------------------------------------

Iteración 2 ejecutar en la raíz del proyecto:

php artisan make:controller DemoPracticasController

- Esto crea app/Http/Controllers/DemoPracticasController.php

- En la ruta resources/views/demo/... están las vistas de los Domains

- Creación de test unitarios (Unit) para el dominio Practica:

php artisan make:test PracticaDomainTest --unit

- Creación de test de rutas (Feature):

php artisan make:test DemoPracticasControllerTest

- Para ejecutar los test en el terminal:

php artisan test

--------------------------------------------------------

Iteración 3: Base de datos + Query Builder

- Crear una base de datos mysql como se explica en los pdf de las sesiones prácticas. Una vez dentro de MySQL se puede introducir este código para crear la base de datos con el mismo nombre:

CREATE DATABASE IF NOT EXISTS gestion_practicas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'laravel'@'localhost'
  IDENTIFIED BY 'laravel123';

GRANT ALL PRIVILEGES ON gestion_practicas.* TO 'laravel'@'localhost';

FLUSH PRIVILEGES;
EXIT;

- Configurar en el .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_practicas
DB_USERNAME=root
DB_PASSWORD=tu_password_aqui

- Desde la raíz del proyecto en una terminal ejecutar lo siguiente para crear las migraciones de la base de datos:

php artisan make:migration create_alumnos_table
php artisan make:migration create_empresas_table
php artisan make:migration create_tutores_table
php artisan make:migration create_practicas_table

IMPORTANTE -> La migración de prácticas tiene que estar de última

- Para ejecutar las migraciones:

php artisan migrate

Para ejecutar de nuevo otra migración con algún cambio:

php artisan migrate:fresh

- Crear seeders para rellenar la base de datos:

php artisan make:seeder AlumnoSeeder
php artisan make:seeder EmpresaSeeder
php artisan make:seeder TutorSeeder
php artisan make:seeder PracticaSeeder

- Para ejecutar los seeders:

php artisan db:seed

Si se quiere limpiar todo y ejecutar desde cero:

php artisan migrate:fresh --seed

- Crear controlador de datos:

php artisan make:controller DbPracticasController

Se genera en app/Http/Controllers/DbPracticasController.php

--------------------------------------------------------
Iteración 4: Eloquent + relaciones

- Crear los modelos Eloquent (no usar -m para no generar nuevas migraciones):

php artisan make:model Alumno
php artisan make:model Empresa
php artisan make:model Tutor
php artisan make:model Practica

Se crean en app/Models/

- Creamos un controlador nuevo:

php artisan make:controller EloquentPracticasController

Se crea en app/Http/Controllers/EloquentPracticasController.php

- Se puede probar en Tinker para ver como la clase Eloquent resuelve las relaciones de forma automática:

php artisan tinker

Dentro de tinker poner de una en una las siguientes instrucciones:

App\Models\Alumno::first();
App\Models\Alumno::with('practicas')->first()->practicas;
App\Models\Practica::with(['alumno','empresa','tutor'])->first();

--------------------------------------------------------

Iteración 5, 6 y 7: CRUD de alumnos, empresas, tutores y prácticas

La iteración 5 muestra el CRUD de alumnos.

La iteración 6 tiene el CRUD de empresas y tutores.

La iteración 7 muestra el CRUD de las prácticas que es el más complejo ya que contiene claves foraneas con las demás clases

--------------------------------------------------------
Iteración 8: Validación de formularios

En esta iteracion se crean los Request de las entidades de la base de datos y ajustamos los Controllers para que tengan en cuenta los Request.

Hay unos test que hacen pruebas básicas para comprobar que las validaciones funcionan correctamente (AdminCrudTest)

--------------------------------------------------------
Iteración 9: Listado de prácticas con filtros y paginación

Se modifica PracticaController.php para que ahora el index() en vez de devolver un get() sin filtros, devuelva un Request y filtros.

También se actualiza index.blade.php para que use filtros y paginación.

También añadimos un test en AdminCrudTest para comprobar el funcionamiento del filtro.

--------------------------------------------------------
Iteración 10: Autenticación + roles + área por tipo de usuario

Usaremos los modelos estándar de Laravel, extendidos con roles -> admin, alumno y tutor

Creamos dos nuevas migraciones una para crear la tabla user y otra para los roles (importante el orden, primero users y después roles):

php artisan make:migration create_users_table

php artisan make:migration add_role_relations_to_users_table

Para crear la carpeta middleware junto con el fichero CheckRole.php ejecutar en terminal en la ubicación del proyecto:

php artisan make:middleware CheckRole

Hay que registrar el middleware en boostrap/app.php para registrar el alias role

En esta sesión también se creó la carpeta Auth en Controllers junto con el controlador del Login (LoginController.php)

Se modificó las rutas de web.php para que usen los middleware de roles.

También se crearon las carpetas dentro de las vistas auth y areas.

Dentro de auth se creó el fichero login.blade.php que es la vista de la página login.

Dentro de areas está alumno.blade.php y tutor.blade.php que contiene las paginas que se muestran cuando se inicia sesión con los respectivos roles.

Alumnos:
correos -> Están en el seeeder de alumno
contraseña -> alumno123

Tutores:
correos -> Están en el seeder de tutores
contraseña -> tutor123

Administrador:
correo -> admin@example.com
contraseña -> admin123

Ahora cuando iniciamos sesion dependiendo del rol tendremos unos permisos específicos.

Se creó también el fichero RolesTest.php en "tests/Feature/RolesTest.php" para hacer pruebas de diferentes casuisticas para comprobar que los permisos de los distintos roles funcionan de la forma esperada.