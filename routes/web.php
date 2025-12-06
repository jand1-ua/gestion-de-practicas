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


