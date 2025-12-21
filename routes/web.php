<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// -------------------------------------------------------------------------------------------
// Home + índice de sesiones

Route::view('/', 'welcome')->name('home');
Route::view('/sesiones', 'sesiones')->name('sesiones');

// -------------------------------------------------------------------------------------------
// Sesión 2 – Laravel básico

use App\Http\Controllers\DemoPracticasController;

Route::get('/demo/alumnos', [DemoPracticasController::class, 'alumnos'])->name('demo.alumnos');
Route::get('/demo/practicas', [DemoPracticasController::class, 'practicas'])->name('demo.practicas');

// -------------------------------------------------------------------------------------------
// Sesión 3 – Acceso a datos (Query Builder)

use App\Http\Controllers\DbPracticasController;

Route::get('/db/alumnos', [DbPracticasController::class, 'alumnos'])->name('db.alumnos');
Route::get('/db/practicas', [DbPracticasController::class, 'practicas'])->name('db.practicas');

// -------------------------------------------------------------------------------------------
// Sesión 4 – Eloquent ORM y relaciones

use App\Http\Controllers\EloquentPracticasController;

Route::get('/eloquent/alumnos', [EloquentPracticasController::class, 'alumnos'])->name('eloquent.alumnos');
Route::get('/eloquent/practicas', [EloquentPracticasController::class, 'practicas'])->name('eloquent.practicas');

// -------------------------------------------------------------------------------------------
// Sesiones 5, 6 y 7 – Zona de coordinación (solo rol coordinador)

use App\Http\Controllers\Admin\AlumnoController as AdminAlumnoController;
use App\Http\Controllers\Admin\EmpresaController as AdminEmpresaController;
use App\Http\Controllers\Admin\TutorController as AdminTutorController;
use App\Http\Controllers\Admin\PracticaController;

Route::middleware(['auth', 'role:coordinador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', function () {
            // Dashboard de coordinador
            return redirect()->route('admin.practicas.index');
        })->name('dashboard');

        // CRUD alumnos
        Route::resource('alumnos', AdminAlumnoController::class);

        // CRUD empresas
        Route::resource('empresas', AdminEmpresaController::class);

        // CRUD tutores
        Route::resource('tutores', AdminTutorController::class)
            ->parameters(['tutores' => 'tutor']);

        // CRUD prácticas
        Route::resource('practicas', PracticaController::class)
            ->names('practicas');
    });

// -------------------------------------------------------------------------------------------
// Sesión 10 – Autenticación + roles + áreas

use App\Http\Controllers\Auth\LoginController;

// login / logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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

// Área de coordinador (opcional: redirige al dashboard)
Route::middleware(['auth', 'role:coordinador'])
    ->get('/area/coordinador', function () {
        return redirect()->route('admin.dashboard');
    })
    ->name('area.coordinador');
