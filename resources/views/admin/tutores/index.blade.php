@extends('layouts.app')

@section('title', 'Tutores · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Tutores</h2>
        <p>Gestión de tutores de empresa y su vinculación con empresas.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.tutores.create') }}">Nuevo tutor</a>
    </div>
</div>

<div class="card">
    <div class="actions" style="justify-content:space-between; width:100%; align-items:flex-end;">
        <div class="field" style="max-width:320px;">
            <label class="label" for="tutores-search">Buscar</label>
            <input class="control" id="tutores-search" type="search" data-autofocus data-table-filter="tutores-table"
                   placeholder="Nombre, email, empresa...">
            <div class="help">Filtro local (no consulta la base de datos).</div>
        </div>
        <div class="muted">{{ $tutores->total() }} registro(s)</div>
    </div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table" id="tutores-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th style="width:210px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tutores as $tutor)
                    <tr>
                        <td class="muted">#{{ $tutor->id }}</td>
                        <td><a href="{{ route('admin.tutores.show', $tutor) }}"><strong>{{ $tutor->nombre }}</strong></a></td>
                        <td>{{ $tutor->empresa->nombre ?? '-' }}</td>
                        <td class="muted">{{ $tutor->email }}</td>
                        <td class="muted">{{ $tutor->telefono }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-sm" href="{{ route('admin.tutores.edit', $tutor) }}">Editar</a>
                                <form action="{{ route('admin.tutores.destroy', $tutor) }}" method="POST"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar este tutor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="muted">No hay tutores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $tutores->links() }}

    <div class="code-panel" style="margin-top:16px;">
        <h3>Código (Sesión 5)</h3>
        <p>CRUD con Route::resource + controlador + validación (FormRequest) + modelo Eloquent con relación a Empresa.</p>

        <div class="code-block">
            <pre><code>@verbatim
routes/web.php
use App\Http\Controllers\Admin\TutorController as AdminTutorController;

Route::middleware(['auth', 'role:coordinador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('tutores', AdminTutorController::class)
            ->parameters(['tutores' => 'tutor']);
    });

app/Http/Controllers/Admin/TutorController.php
&lt;?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\Empresa;
use App\Http\Requests\Admin\TutorRequest;

class TutorController extends Controller
{
    public function index()
    {
        $tutores = Tutor::with('empresa')
            ->orderBy('id')
            ->paginate(10);

        return view('admin.tutores.index', compact('tutores'));
    }

    public function create()
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('admin.tutores.create', compact('empresas'));
    }

    public function store(TutorRequest $request)
    {
        Tutor::create($request->validated());

        return redirect()
            ->route('admin.tutores.index')
            ->with('success', 'Tutor creado correctamente.');
    }

    public function show(Tutor $tutor)
    {
        $tutor->load('empresa');

        return view('admin.tutores.show', compact('tutor'));
    }

    public function edit(Tutor $tutor)
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('admin.tutores.edit', compact('tutor', 'empresas'));
    }

    public function update(TutorRequest $request, Tutor $tutor)
    {
        $tutor->update($request->validated());

        return redirect()
            ->route('admin.tutores.index')
            ->with('success', 'Tutor actualizado correctamente.');
    }

    public function destroy(Tutor $tutor)
    {
        if ($tutor->practicas()->exists()) {
            return redirect()
                ->route('admin.tutores.index')
                ->with('error', 'No se puede eliminar un tutor con prácticas asociadas.');
        }

        $tutor->delete();

        return redirect()
            ->route('admin.tutores.index')
            ->with('success', 'Tutor eliminado correctamente.');
    }
}

app/Http/Requests/Admin/TutorRequest.php
&lt;?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tutor = $this->route('tutor');
        $tutorId = $tutor ? $tutor->id : null;

        return [
            'empresa_id' => ['required', 'exists:empresas,id'],
            'nombre'     => ['required', 'string', 'max:150'],
            'email'      => [
                'required',
                'email',
                'max:150',
                Rule::unique('tutores', 'email')->ignore($tutorId),
            ],
            'telefono'   => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'empresa_id.required' => 'Debes seleccionar una empresa.',
            'empresa_id.exists'   => 'La empresa seleccionada no existe.',
            'nombre.required'     => 'El nombre del tutor es obligatorio.',
            'email.required'      => 'El email es obligatorio.',
            'email.email'         => 'El email no es válido.',
            'email.unique'        => 'Ya existe un tutor con ese email.',
        ];
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
