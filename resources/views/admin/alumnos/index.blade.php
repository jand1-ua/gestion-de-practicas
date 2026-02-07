@extends('layouts.app')

@section('title', 'Alumnos · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Alumnos</h2>
        <p>Gestión de alumnos registrados en el sistema.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.alumnos.create') }}">Nuevo alumno</a>
    </div>
</div>

<div class="card">
    <div class="actions" style="justify-content:space-between; width:100%; align-items:flex-end;">
        <div class="field" style="max-width:320px;">
            <label class="label" for="alumnos-search">Buscar</label>
            <input class="control" id="alumnos-search" type="search" data-autofocus data-table-filter="alumnos-table"
                   placeholder="Nombre, email, grado...">
            <div class="help">Filtro local (no consulta la base de datos).</div>
        </div>
        <div class="muted">{{ $alumnos->total() }} registro(s)</div>
    </div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table" id="alumnos-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Grado</th>
                    <th>Curso</th>
                    <th style="width:210px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnos as $alumno)
                    <tr>
                        <td class="muted">#{{ $alumno->id }}</td>
                        <td>
                            <a href="{{ route('admin.alumnos.show', $alumno) }}"><strong>{{ $alumno->nombre }}</strong></a>
                        </td>
                        <td class="muted">{{ $alumno->email }}</td>
                        <td>{{ $alumno->grado }}</td>
                        <td>{{ $alumno->curso }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-sm" href="{{ route('admin.alumnos.edit', $alumno) }}">Editar</a>
                                <form action="{{ route('admin.alumnos.destroy', $alumno) }}" method="POST"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar este alumno?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="muted">No hay alumnos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $alumnos->links() }}

    <div class="code-panel" style="margin-top:16px;">
        <h3>Código (Sesión 5)</h3>
        <p>CRUD con Route::resource + controlador + validación (FormRequest) + modelo Eloquent.</p>

        <div class="code-block">
            <pre><code>@verbatim
routes/web.php
use App\Http\Controllers\Admin\AlumnoController as AdminAlumnoController;

Route::middleware(['auth', 'role:coordinador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('alumnos', AdminAlumnoController::class);
    });

app/Http/Controllers/Admin/AlumnoController.php
&lt;?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Http\Requests\Admin\AlumnoRequest;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::orderBy('id')->paginate(10);

        return view('admin.alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        return view('admin.alumnos.create');
    }

    public function store(AlumnoRequest $request)
    {
        $data = $request->validated();
        Alumno::create($data);

        return redirect()
            ->route('admin.alumnos.index')
            ->with('success', 'Alumno creado correctamente.');
    }

    public function show(Alumno $alumno)
    {
        return view('admin.alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        return view('admin.alumnos.edit', compact('alumno'));
    }

    public function update(AlumnoRequest $request, Alumno $alumno)
    {
        $data = $request->validated();
        $alumno->update($data);

        return redirect()
            ->route('admin.alumnos.index')
            ->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        if ($alumno->practicas()->exists()) {
            return redirect()
                ->route('admin.alumnos.index')
                ->with('error', 'No se puede eliminar un alumno con prácticas asociadas.');
        }

        $alumno->delete();

        return redirect()
            ->route('admin.alumnos.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }
}

app/Http/Requests/Admin/AlumnoRequest.php
&lt;?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $alumno = $this->route('alumno');
        $alumnoId = $alumno ? $alumno->id : null;

        return [
            'nombre' => ['required', 'string', 'max:150'],
            'email'  => [
                'required',
                'email',
                'max:150',
                Rule::unique('alumnos', 'email')->ignore($alumnoId),
            ],
            'grado'  => ['required', 'string', 'max:150'],
            'curso'  => ['required', 'string', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required'  => 'El email es obligatorio.',
            'email.email'     => 'El email no tiene un formato válido.',
            'email.unique'    => 'Ya existe un alumno con ese email.',
            'grado.required'  => 'El grado es obligatorio.',
            'curso.required'  => 'El curso es obligatorio.',
        ];
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
@endverbatim</code></pre>
        </div>
    </div>
</div>
@endsection
