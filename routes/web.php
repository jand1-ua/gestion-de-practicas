<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// -------------------------------------------------------------------------------------------
// Página de bienvenida

Route::view('/', 'welcome')->name('home');          
Route::view('/sesiones', 'sesiones')->name('sesiones'); 

// -------------------------------------------------------------------------------------------
// Sesión 2

use App\Http\Controllers\DemoPracticasController;

Route::get('/demo/alumnos', [DemoPracticasController::class, 'alumnos']);
Route::get('/demo/practicas', [DemoPracticasController::class, 'practicas']);

// -------------------------------------------------------------------------------------------
// Sesión 3

use App\Http\Controllers\DbPracticasController;

Route::get('/db/alumnos', [DbPracticasController::class, 'alumnos'])
    ->name('db.alumnos');

Route::get('/db/practicas', [DbPracticasController::class, 'practicas'])
    ->name('db.practicas');

// -------------------------------------------------------------------------------------------
// Sesión 4

use App\Http\Controllers\EloquentPracticasController;

Route::get('/eloquent/alumnos', [EloquentPracticasController::class, 'alumnos'])
    ->name('eloquent.alumnos');

Route::get('/eloquent/practicas', [EloquentPracticasController::class, 'practicas'])
    ->name('eloquent.practicas');

// -------------------------------------------------------------------------------------------
// Sesiones 5, 6 y 7 – Zona de administración (solo rol admin)

use App\Http\Controllers\Admin\AlumnoController as AdminAlumnoController;
use App\Http\Controllers\Admin\EmpresaController as AdminEmpresaController;
use App\Http\Controllers\Admin\TutorController as AdminTutorController;
use App\Http\Controllers\Admin\PracticaController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', function () {
            // Pequeño “dashboard” de admin
            return redirect()->route('admin.practicas.index');
        })->name('dashboard');

        // Alumnos (iteración 5)
        Route::resource('alumnos', AdminAlumnoController::class);

        // Empresas (iteración 6)
        Route::resource('empresas', AdminEmpresaController::class);

        // Tutores (iteración 6)
        Route::resource('tutores', AdminTutorController::class)
            ->parameters(['tutores' => 'tutor']);

        // Prácticas (iteraciones 6–8)
        Route::resource('practicas', PracticaController::class)
            ->names('practicas');
    });

// -------------------------------------------------------------------------------------------
// Sesión 10 – Autenticación + roles + áreas

use App\Http\Controllers\Auth\LoginController;

// login / logout
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Área de alumno
Route::middleware(['auth', 'role:alumno'])
    ->get('/area/alumno', function () {
        $user = Auth::user();
        $alumno = $user->alumno ? $user->alumno->load(['practicas.empresa', 'practicas.tutor']) : null;

        return view('areas.alumno', compact('user', 'alumno'));
    })
    ->name('area.alumno');

// Área de tutor
Route::middleware(['auth', 'role:tutor'])
    ->get('/area/tutor', function () {
        $user = Auth::user();
        $tutor = $user->tutor ? $user->tutor->load(['practicas.alumno', 'practicas.empresa']) : null;

        return view('areas.tutor', compact('user', 'tutor'));
    })
    ->name('area.tutor');


// -----------------------------------------------------------------------------
// Mensajería interna (Sesión 11 / Iteración final)

use App\Http\Controllers\MensajeController;

Route::middleware('auth')->group(function () {
    Route::resource('mensajes', MensajeController::class)
        ->only(['index', 'create', 'store', 'show'])
        ->names('mensajes');
});
