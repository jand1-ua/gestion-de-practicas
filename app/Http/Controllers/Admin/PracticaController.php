<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Tutor;
use App\Models\Practica;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PracticaRequest;
use App\Services\Practicas\AsignarPracticaService;
use Illuminate\Support\Facades\Auth;

class PracticaController extends Controller
{
    public function index(Request $request)
    {
        $query = Practica::withRelations()->orderBy('id');

        if ($request->filled('estado')) {
            $query->byEstado($request->estado);
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
        $data = $request->validated();

        $coordinador = Auth::user();

        app(AsignarPracticaService::class)->asignar($data, $coordinador);

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
        $data = $request->validated();

        $tutor = Tutor::findOrFail($data['tutor_id']);
        $data['empresa_id'] = $data['empresa_id'] ?? $tutor->empresa_id;

        if ((int) $data['empresa_id'] !== (int) $tutor->empresa_id) {
            return back()->withErrors([
                'empresa_id' => 'La empresa debe coincidir con la empresa del tutor seleccionado.',
            ])->withInput();
        }

        $practica->update($data);

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
