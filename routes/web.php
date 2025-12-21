<?php

use Illuminate\Support\Facades\Route;

// -------------------------------------------------------------------------------------------
// Home + índice de sesiones

Route::view('/', 'welcome')->name('home');
Route::view('/sesiones', 'sesiones')->name('sesiones');

// -------------------------------------------------------------------------------------------
// Sesión 2

use App\Http\Controllers\DemoPracticasController;

Route::get('/demo/alumnos', [DemoPracticasController::class, 'alumnos'])->name('demo.alumnos');
Route::get('/demo/practicas', [DemoPracticasController::class, 'practicas'])->name('demo.practicas');

// -------------------------------------------------------------------------------------------
// Sesión 3

use App\Http\Controllers\DbPracticasController;

Route::get('/db/alumnos', [DbPracticasController::class, 'alumnos'])->name('db.alumnos');
Route::get('/db/practicas', [DbPracticasController::class, 'practicas'])->name('db.practicas');

// -------------------------------------------------------------------------------------------
// Sesión 4

use App\Http\Controllers\EloquentPracticasController;

Route::get('/eloquent/alumnos', [EloquentPracticasController::class, 'alumnos'])->name('eloquent.alumnos');
Route::get('/eloquent/practicas', [EloquentPracticasController::class, 'practicas'])->name('eloquent.practicas');

// -------------------------------------------------------------------------------------------
// Sesión 5 y 6

use App\Http\Controllers\Admin\AlumnoController as AdminAlumnoController;
use App\Http\Controllers\Admin\EmpresaController as AdminEmpresaController;
use App\Http\Controllers\Admin\TutorController as AdminTutorController;
use App\Http\Controllers\Admin\PracticaController as AdminPracticaController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('alumnos', AdminAlumnoController::class);
    Route::resource('empresas', AdminEmpresaController::class);
    Route::resource('tutores', AdminTutorController::class);
    Route::resource('practicas', AdminPracticaController::class); // SESIÓN 7
});
