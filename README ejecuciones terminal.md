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

