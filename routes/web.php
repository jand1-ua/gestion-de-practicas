<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoPracticasController;

Route::view('/', 'welcome')->name('home');
Route::view('/sesiones', 'sesiones')->name('sesiones');

// -------------------------------------------------------------------------------------------
// Sesión 2

Route::get('/demo/alumnos', [DemoPracticasController::class, 'alumnos'])->name('demo.alumnos');
Route::get('/demo/practicas', [DemoPracticasController::class, 'practicas'])->name('demo.practicas');
