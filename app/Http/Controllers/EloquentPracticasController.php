<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Practica;

class EloquentPracticasController extends Controller
{
    
    
    public function alumnos()
    {
        $alumnos = Alumno::with('practicas')
            ->orderBy('id')
            ->get();

        return view('eloquent.alumnos', compact('alumnos'));
    }

    
    public function practicas()
    {
        $practicas = Practica::with(['alumno', 'empresa', 'tutor'])
            ->orderBy('id')
            ->get();

        return view('eloquent.practicas', compact('practicas'));
    }
}
