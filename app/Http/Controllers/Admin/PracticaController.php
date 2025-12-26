<?php

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
        // Construimos la consulta base con las relaciones necesarias
        $query = Practica::with(['alumno', 'empresa', 'tutor'])
            ->orderBy('id');

        // Filtros opcionales
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

        // Paginación (10 por página) y preservamos los filtros en los enlaces
        $practicas = $query->paginate(10)->appends($request->query());

        // Listas auxiliares para los combos de filtro
        $alumnos  = Alumno::orderBy('nombre')->get();
        $empresas = Empresa::orderBy('nombre')->get();
        $tutores  = Tutor::orderBy('nombre')->get();

        // Estados válidos 
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
