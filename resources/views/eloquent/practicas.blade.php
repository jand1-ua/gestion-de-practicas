@extends('layouts.app')

@section('title', 'Eloquent · Prácticas')

@section('content')
<div class="pagehead">
    <div>
        <h2>Eloquent: prácticas</h2>
        <p>Listado obtenido con Eloquent y relaciones práctica → alumno/empresa/tutor.</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('eloquent.alumnos') }}">Ver alumnos (Eloquent)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ $practicas->count() }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Alumno</th>
                <th>Empresa</th>
                <th>Tutor</th>
                <th>Estado</th>
                <th>Inicio</th>
                <th>Fin</th>
            </tr>
            </thead>
            <tbody>
            @foreach($practicas as $practica)
                @php
                    $estado = $practica->estado;
                    $label = $estado === 'en_curso' ? 'En curso' : ucfirst($estado);
                    $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                @endphp
                <tr>
                    <td class="muted">#{{ $practica->id }}</td>
                    <td><strong>{{ $practica->alumno->nombre ?? '-' }}</strong></td>
                    <td>{{ $practica->empresa->nombre ?? '-' }}</td>
                    <td>{{ $practica->tutor->nombre ?? '-' }}</td>
                    <td><span class="badge {{ $badge }}">{{ $label }}</span></td>
                    <td class="muted">{{ $practica->fecha_inicio }}</td>
                    <td class="muted">{{ $practica->fecha_fin ?? '—' }}</td>
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

app/Models/Empresa.php
&lt;?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'nombre',
        'cif',
        'sector',
        'ciudad',
        'email_contacto',
        'telefono_contacto',
    ];

    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class);
    }
}

app/Models/Tutor.php
&lt;?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutor extends Model
{
    use HasFactory;

    protected $table = 'tutores';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'email',
        'telefono',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class);
    }
}
@endverbatim</code></pre>
        </div>
    </div>
</div>
@endsection
