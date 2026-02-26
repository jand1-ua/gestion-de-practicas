@extends('layouts.app')

@section('title', 'Demo · Prácticas')

@section('content')
<div class="pagehead">
    <div>
        <h2>Prácticas (demo)</h2>
        <p>Listado generado desde clases de dominio (sin base de datos).</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('demo.alumnos') }}">Alumnos (demo)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ count($practicas) }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Alumno</th>
                    <th>Empresa</th>
                    <th>Tutor</th>
                    <th>Duración (días)</th>
                    <th>Estado hoy</th>
                </tr>
            </thead>
            <tbody>
                @foreach($practicas as $practica)
                    @php
                        $estado = $practica->getEstado();
                        $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                    @endphp
                    <tr>
                        <td class="muted">#{{ $practica->getId() }}</td>
                        <td><strong>{{ $practica->getAlumno()->getNombre() }}</strong></td>
                        <td>{{ $practica->getEmpresa()->getNombre() }}</td>
                        <td>{{ $practica->getTutor()->getNombre() }}</td>
                        <td class="muted">{{ $practica->getDuracionEnDias() }}</td>
                        <td><span class="badge {{ $badge }}">{{ $estado }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="code-panel" style="margin-top:16px;">
        <h3>Código (Sesión 2)</h3>
        <p>Código completo usado para generar la lista de prácticas (web.php + controlador).</p>

        <div class="code-block">
            <pre><code>@verbatim
routes/web.php
use App\Http\Controllers\DemoPracticasController;

Route::get('/demo/practicas', [DemoPracticasController::class, 'practicas'])->name('demo.practicas');

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
