@extends('layouts.app')

@section('title', 'Demo · Alumnos')

@section('content')
<div class="pagehead">
    <div>
        <h2>Alumnos (demo)</h2>
        <p>Listado generado desde clases de dominio (sin base de datos).</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('demo.practicas') }}">Prácticas (demo)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ count($alumnos) }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Grado</th>
                    <th>Curso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                    <tr>
                        <td class="muted">#{{ $alumno->getId() }}</td>
                        <td><strong>{{ $alumno->getNombre() }}</strong></td>
                        <td class="muted">{{ $alumno->getEmail() }}</td>
                        <td>{{ $alumno->getGrado() }}</td>
                        <td>{{ $alumno->getCurso() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="code-panel" style="margin-top:16px;">
        <h3>Código (Sesión 2)</h3>
        <p>Código completo usado para generar la lista de alumnos (web.php + controlador).</p>

        <div class="code-block">
            <pre><code>@verbatim
routes/web.php
use App\Http\Controllers\DemoPracticasController;

Route::get('/demo/alumnos', [DemoPracticasController::class, 'alumnos'])->name('demo.alumnos');

app/Http/Controllers/DemoPracticasController.php
&lt;?php

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
@endverbatim</code></pre>
        </div>
    </div>
</div>
@endsection
