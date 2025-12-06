<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Practica;

class EloquentPracticasController extends Controller
{
    
    // Listado de alumnos con nº de prácticas (usando relaciones).

    public function alumnos()
    {
        // Carga todos los alumnos con sus prácticas
        $alumnos = Alumno::with('practicas')
            ->orderBy('id')
            ->get();

        return view('eloquent.alumnos', compact('alumnos'));
    }

    
    // Listado de prácticas con su alumno, empresa y tutor.
    
    public function practicas()
    {
        $practicas = Practica::with(['alumno', 'empresa', 'tutor'])
            ->orderBy('id')
            ->get();

        return view('eloquent.practicas', compact('practicas'));
    }
}
