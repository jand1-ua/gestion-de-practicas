@extends('layouts.app')

@section('title', 'Empresas · Panel coordinador')

@section('content')
@include('partials.admin-subnav')

<div class="pagehead">
    <div>
        <h2>Empresas</h2>
        <p>Gestión de empresas colaboradoras y sus datos de contacto.</p>
    </div>

    <div class="actions">
        <a class="btn btn-primary" href="{{ route('admin.empresas.create') }}">Nueva empresa</a>
    </div>
</div>

<div class="card">
    <div class="actions" style="justify-content:space-between; width:100%; align-items:flex-end;">
        <div class="field" style="max-width:320px;">
            <label class="label" for="empresas-search">Buscar</label>
            <input class="control" id="empresas-search" type="search" data-autofocus data-table-filter="empresas-table"
                   placeholder="Nombre, CIF, sector, ciudad...">
            <div class="help">Filtro local (no consulta la base de datos).</div>
        </div>
        <div class="muted">{{ $empresas->total() }} registro(s)</div>
    </div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table" id="empresas-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>CIF</th>
                    <th>Sector</th>
                    <th>Ciudad</th>
                    <th>Contacto</th>
                    <th style="width:210px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empresas as $empresa)
                    <tr>
                        <td class="muted">#{{ $empresa->id }}</td>
                        <td><a href="{{ route('admin.empresas.show', $empresa) }}"><strong>{{ $empresa->nombre }}</strong></a></td>
                        <td class="muted">{{ $empresa->cif }}</td>
                        <td>{{ $empresa->sector }}</td>
                        <td>{{ $empresa->ciudad }}</td>
                        <td class="muted">
                            {{ $empresa->email_contacto }}<br>
                            {{ $empresa->telefono_contacto }}
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-sm" href="{{ route('admin.empresas.edit', $empresa) }}">Editar</a>
                                <form action="{{ route('admin.empresas.destroy', $empresa) }}" method="POST"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar esta empresa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="muted">No hay empresas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $empresas->links() }}

    <div class="code-panel" style="margin-top:16px;">
        <h3>Código (Sesión 5)</h3>
        <p>CRUD con Route::resource + controlador + validación (FormRequest) + modelo Eloquent.</p>

        <div class="code-block">
            <pre><code>@verbatim
routes/web.php
use App\Http\Controllers\Admin\EmpresaController as AdminEmpresaController;

Route::middleware(['auth', 'role:coordinador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('empresas', AdminEmpresaController::class);
    });

app/Http/Controllers/Admin/EmpresaController.php
&lt;?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Http\Requests\Admin\EmpresaRequest;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::orderBy('id')->paginate(10);

        return view('admin.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('admin.empresas.create');
    }

    public function store(EmpresaRequest $request)
    {
        Empresa::create($request->validated());

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa creada correctamente.');
    }

    public function show(Empresa $empresa)
    {
        return view('admin.empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('admin.empresas.edit', compact('empresa'));
    }

    public function update(EmpresaRequest $request, Empresa $empresa)
    {
        $empresa->update($request->validated());

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa actualizada correctamente.');
    }

    public function destroy(Empresa $empresa)
    {
        if ($empresa->practicas()->exists()) {
            return redirect()
                ->route('admin.empresas.index')
                ->with('error', 'No se puede eliminar una empresa con prácticas asociadas.');
        }

        $empresa->delete();

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa eliminada correctamente.');
    }
}

app/Http/Requests/Admin/EmpresaRequest.php
&lt;?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $empresa = $this->route('empresa');
        $empresaId = $empresa ? $empresa->id : null;

        return [
            'nombre'            => ['required', 'string', 'max:150'],
            'cif'               => [
                'required',
                'string',
                'max:20',
                Rule::unique('empresas', 'cif')->ignore($empresaId),
            ],
            'sector'            => ['nullable', 'string', 'max:150'],
            'ciudad'            => ['nullable', 'string', 'max:100'],
            'email_contacto'    => ['nullable', 'email', 'max:150'],
            'telefono_contacto' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la empresa es obligatorio.',
            'cif.required'    => 'El CIF es obligatorio.',
            'cif.unique'      => 'Ya existe una empresa con ese CIF.',
            'email_contacto.email' => 'El email de contacto no es válido.',
        ];
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
@endverbatim</code></pre>
        </div>
    </div>
</div>
@endsection
