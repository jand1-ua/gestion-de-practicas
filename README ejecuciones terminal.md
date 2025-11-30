Iteración 1 (carpeta sesion_1):

-> probar código de 1-arrays: 

php sesion_1/1-arrays/demo_listados.php

-> Probar código de 2-poo:

php sesion_1/2-poo/demo_poo.php

-> Probar código de 3-namespaces:

php sesion_1/3-namespaces/demo_namespaces.php

-----------------------------

Iteración 2 ejecutar en la raíz del proyecto:

php artisan make:controller DemoPracticasController

Esto crea app/Http/Controllers/DemoPracticasController.php

En la ruta resources/views/demo/
Están las vistas de los Domains

Creación de test unitarios (Unit) para el dominio Practica:

php artisan make:test PracticaDomainTest --unit

ECreación de test de rutas (Feature):

php artisan make:test DemoPracticasControllerTest

Para ejecutar los test en el terminal:

php artisan test