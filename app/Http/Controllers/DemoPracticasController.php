<?php

namespace App\Http\Controllers;

use App\Domain\DatosPrueba;
use Illuminate\Support\Facades\Log;

class DemoPracticasController extends Controller
{
    public function alumnos()
    {
        $data    = DatosPrueba::crear();
        $alumnos = $data['alumnos'];

        Log::info('Listando alumnos de demo', ['total' => count($alumnos)]);

        return view('demo.alumnos', compact('alumnos'));
    }

    public function practicas()
    {
        $data      = DatosPrueba::crear();
        $practicas = $data['practicas'];

        Log::info('Listando prácticas de demo', ['total' => count($practicas)]);

        return view('demo.practicas', compact('practicas'));
    }
}
