<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbPracticasController extends Controller
{
    // Listado de alumnos desde la BD
    public function alumnos()
    {
        $alumnos = DB::table('alumnos')
            ->orderBy('nombre')
            ->get();

        return view('db.alumnos', [
            'alumnos' => $alumnos,
        ]);
    }

    // Listado de prácticas con joins para ver alumno, empresa y tutor
    public function practicas()
    {
        $practicas = DB::table('practicas')
            ->join('alumnos', 'practicas.alumno_id', '=', 'alumnos.id')
            ->join('empresas', 'practicas.empresa_id', '=', 'empresas.id')
            ->join('tutores', 'practicas.tutor_id', '=', 'tutores.id')
            ->select(
                'practicas.id',
                'alumnos.nombre as alumno',
                'empresas.nombre as empresa',
                'tutores.nombre as tutor',
                'practicas.estado',
                'practicas.fecha_inicio',
                'practicas.fecha_fin'
            )
            ->orderBy('practicas.id')
            ->get();

        return view('db.practicas', [
            'practicas' => $practicas,
        ]);
    }
}
