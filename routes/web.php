<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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

// Sesion 5 y 6

use App\Http\Controllers\Admin\AlumnoController as AdminAlumnoController;
use App\Http\Controllers\Admin\EmpresaController as AdminEmpresaController;
use App\Http\Controllers\Admin\TutorController as AdminTutorController;

Route::prefix('admin')->name('admin.')->group(function () {

    // Alumnos (iteración 5)
    Route::resource('alumnos', AdminAlumnoController::class);

    // Empresas (nueva)
    Route::resource('empresas', AdminEmpresaController::class);

    // Tutores (nueva)
    Route::resource('tutores', AdminTutorController::class)
        ->parameters(['tutores' => 'tutor']);
});
