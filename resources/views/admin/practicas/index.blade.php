@extends('layouts.app')

@section('title', 'Prácticas · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

@php
    $estadoActual = request('estado');
    $empresaActual = request('empresa_id');
    $alumnoActual = request('alumno_id');
    $tutorActual = request('tutor_id');
@endphp

<div class="pagehead">
    <div>
        <h2>Prácticas</h2>
        <p>Listado y filtros de asignaciones de prácticas.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.practicas.create') }}">Nueva práctica</a>
    </div>
</div>

<div class="card">
    <h3>Filtros</h3>
    <p class="muted">Los filtros consultan la base de datos. Puedes además usar la búsqueda local para filtrar la tabla actual.</p>

    <form method="GET" action="{{ route('admin.practicas.index') }}" class="form" style="margin-top:12px;">
        <div class="field-row">
            <div class="field">
                <label class="label" for="estado">Estado</label>
                <select class="select" name="estado" id="estado">
                    @foreach($estados as $value => $label)
                        <option value="{{ $value }}" @selected((string) $estadoActual === (string) $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="label" for="empresa_id">Empresa</label>
                <select class="select" name="empresa_id" id="empresa_id">
                    <option value="">Todas</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}" @selected((string) $empresaActual === (string) $empresa->id)>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="field-row">
            <div class="field">
                <label class="label" for="alumno_id">Alumno</label>
                <select class="select" name="alumno_id" id="alumno_id">
                    <option value="">Todos</option>
                    @foreach ($alumnos as $alumno)
                        <option value="{{ $alumno->id }}" @selected((string) $alumnoActual === (string) $alumno->id)>
                            {{ $alumno->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="label" for="tutor_id">Tutor</label>
                <select class="select" name="tutor_id" id="tutor_id">
                    <option value="">Todos</option>
                    @foreach ($tutores as $tutor)
                        <option value="{{ $tutor->id }}" @selected((string) $tutorActual === (string) $tutor->id)>
                            {{ $tutor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="actions">
            <button class="btn btn-primary" type="submit">Aplicar filtros</button>
            <a class="btn" href="{{ route('admin.practicas.index') }}">Limpiar</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="actions" style="justify-content:space-between; width:100%; align-items:flex-end;">
        <div class="field" style="max-width:320px;">
            <label class="label" for="practicas-search">Buscar en esta página</label>
            <input class="control" id="practicas-search" type="search" data-table-filter="practicas-table"
                   placeholder="Alumno, empresa, tutor, observaciones...">
            <div class="help">Filtro local (no afecta a los enlaces de paginación).</div>
        </div>
        <div class="muted">{{ $practicas->total() }} registro(s)</div>
    </div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table" id="practicas-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Alumno</th>
                <th>Empresa</th>
                <th>Tutor</th>
                <th>Estado</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Observaciones</th>
                <th style="width:240px;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($practicas as $practica)
                @php
                    $estado = $practica->estado;
                    $estadoLabel = $estado === 'en_curso' ? 'En curso' : ucfirst($estado);
                    $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                @endphp
                <tr>
                    <td class="muted">#{{ $practica->id }}</td>
                    <td>{{ $practica->alumno->nombre ?? '-' }}</td>
                    <td>{{ $practica->empresa->nombre ?? '-' }}</td>
                    <td>{{ $practica->tutor->nombre ?? '-' }}</td>
                    <td><span class="badge {{ $badge }}">{{ $estadoLabel }}</span></td>
                    <td class="muted">{{ $practica->fecha_inicio }}</td>
                    <td class="muted">{{ $practica->fecha_fin ?? '—' }}</td>
                    <td style="max-width: 360px;">{{ $practica->observaciones }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-sm" href="{{ route('admin.practicas.show', $practica) }}">Ver</a>
                            <a class="btn btn-sm" href="{{ route('admin.practicas.edit', $practica) }}">Editar</a>
                            <form action="{{ route('admin.practicas.destroy', $practica) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar práctica?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="muted">No hay prácticas registradas con los filtros seleccionados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $practicas->links() }}

    <div class="code-panel" style="margin-top:16px;">
        <h3>Código (Sesión 5)</h3>
        <p>CRUD con Route::resource + controlador con filtros + validación (FormRequest) + modelo Eloquent con relaciones.</p>

        <div class="code-block">
            <pre><code>@verbatim
routes/web.php
use App\Http\Controllers\Admin\PracticaController;

Route::middleware(['auth', 'role:coordinador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('practicas', PracticaController::class)
            ->names('practicas');
    });

app/Http/Controllers/Admin/PracticaController.php
&lt;?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Tutor;
use App\Models\Practica;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PracticaRequest;

class PracticaController extends Controller
{
    public function index(Request $request)
    {
        $query = Practica::with(['alumno', 'empresa', 'tutor'])
            ->orderBy('id');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('empresa_id')) {
            $query->where('empresa_id', $request->empresa_id);
        }

        if ($request->filled('alumno_id')) {
            $query->where('alumno_id', $request->alumno_id);
        }

        if ($request->filled('tutor_id')) {
            $query->where('tutor_id', $request->tutor_id);
        }

        $practicas = $query->paginate(10)->appends($request->query());

        $alumnos  = Alumno::orderBy('nombre')->get();
        $empresas = Empresa::orderBy('nombre')->get();
        $tutores  = Tutor::orderBy('nombre')->get();

        $estados = [
            ''           => 'Todos',
            'en_curso'   => 'En curso',
            'pendiente'  => 'Pendiente',
            'finalizada' => 'Finalizada',
        ];

        return view('admin.practicas.index', compact(
            'practicas',
            'alumnos',
            'empresas',
            'tutores',
            'estados'
        ));
    }

    public function create()
    {
        $alumnos  = Alumno::orderBy('nombre')->get();
        $empresas = Empresa::orderBy('nombre')->get();
        $tutores  = Tutor::with('empresa')->orderBy('nombre')->get();

        return view('admin.practicas.create', compact('alumnos', 'empresas', 'tutores'));
    }

    public function store(PracticaRequest $request)
    {
        Practica::create($request->validated());

        return redirect()
            ->route('admin.practicas.index')
            ->with('success', 'Práctica creada correctamente.');
    }

    public function show(Practica $practica)
    {
        $practica->load(['alumno', 'empresa', 'tutor']);

        return view('admin.practicas.show', compact('practica'));
    }

    public function edit(Practica $practica)
    {
        $alumnos  = Alumno::orderBy('nombre')->get();
        $empresas = Empresa::orderBy('nombre')->get();
        $tutores  = Tutor::with('empresa')->orderBy('nombre')->get();

        return view('admin.practicas.edit', compact('practica', 'alumnos', 'empresas', 'tutores'));
    }

    public function update(PracticaRequest $request, Practica $practica)
    {
        $practica->update($request->validated());

        return redirect()
            ->route('admin.practicas.index')
            ->with('success', 'Práctica actualizada correctamente.');
    }

    public function destroy(Practica $practica)
    {
        if ($practica->estado === 'en_curso') {
            return redirect()
                ->route('admin.practicas.index')
                ->with('error', 'No se puede eliminar una práctica que está en curso.');
        }

        $practica->delete();

        return redirect()
            ->route('admin.practicas.index')
            ->with('success', 'Práctica eliminada correctamente.');
    }
}

app/Http/Requests/Admin/PracticaRequest.php
&lt;?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PracticaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $estados = ['en_curso', 'pendiente', 'finalizada'];

        return [
            'alumno_id'     => ['required', 'exists:alumnos,id'],
            'empresa_id'    => ['required', 'exists:empresas,id'],
            'tutor_id'      => ['required', 'exists:tutores,id'],
            'fecha_inicio'  => ['required', 'date'],
            'fecha_fin'     => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'estado'        => ['required', 'string', Rule::in($estados)],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'alumno_id.required'   => 'Debes seleccionar un alumno.',
            'alumno_id.exists'     => 'El alumno seleccionado no existe.',
            'empresa_id.required'  => 'Debes seleccionar una empresa.',
            'empresa_id.exists'    => 'La empresa seleccionada no existe.',
            'tutor_id.required'    => 'Debes seleccionar un tutor.',
            'tutor_id.exists'      => 'El tutor seleccionado no existe.',
            'fecha_inicio.required'=> 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date'    => 'La fecha de inicio no es válida.',
            'fecha_fin.date'       => 'La fecha de fin no es válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la de inicio.',
            'estado.required'      => 'El estado es obligatorio.',
            'estado.in'            => 'El estado seleccionado no es válido.',
        ];
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
