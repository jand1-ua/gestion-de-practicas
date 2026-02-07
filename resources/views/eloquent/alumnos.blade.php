@extends('layouts.app')

@section('title', 'Eloquent · Alumnos')

@section('content')
<div class="pagehead">
    <div>
        <h2>Eloquent: alumnos</h2>
        <p>Listado obtenido con Eloquent y relación alumno → prácticas.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('eloquent.practicas') }}">Ver prácticas (Eloquent)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ $alumnos->count() }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Grado</th>
                    <th>Curso</th>
                    <th>Prácticas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                    <tr>
                        <td class="muted">#{{ $alumno->id }}</td>
                        <td><strong>{{ $alumno->nombre }}</strong></td>
                        <td class="muted">{{ $alumno->email }}</td>
                        <td>{{ $alumno->grado }}</td>
                        <td>{{ $alumno->curso }}</td>
                        <td>
                            <span class="badge {{ $alumno->practicas->count() ? 'badge-info' : '' }}">
                                {{ $alumno->practicas->count() }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="code-panel" style="margin-top:16px;">
        <h3>Código (Sesión 4)</h3>
        <p>Eloquent ORM y relaciones: rutas, controlador, modelos y relaciones.</p>

        <div class="code-block">
            <pre><code>@verbatim
routes/web.php
use App\Http\Controllers\EloquentPracticasController;

Route::get('/eloquent/alumnos', [EloquentPracticasController::class, 'alumnos'])->name('eloquent.alumnos');
Route::get('/eloquent/practicas', [EloquentPracticasController::class, 'practicas'])->name('eloquent.practicas');

app/Http/Controllers/EloquentPracticasController.php
&lt;?php

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

app/Models/Alumno.php
&lt;?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'email',
        'grado',
        'curso',
    ];

    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class);
    }
}

app/Models/Practica.php
&lt;?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Practica extends Model
{
    use HasFactory;

    protected $table = 'practicas';

    protected $fillable = [
        'alumno_id',
        'empresa_id',
        'tutor_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'observaciones',
    ];

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }
}
@endverbatim</code></pre>
        </div>
    </div>
</div>
@endsection
