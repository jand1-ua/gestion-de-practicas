<?php

use Illuminate\Support\Facades\Route;

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
