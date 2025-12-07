<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Tutor;
use App\Models\Practica;
use Illuminate\Http\Request;

class PracticaController extends Controller
{
    public function index()
    {
        $practicas = Practica::with(['alumno', 'empresa', 'tutor'])
            ->orderBy('id')
            ->get();

        return view('admin.practicas.index', compact('practicas'));
    }

    public function create()
    {
        $alumnos  = Alumno::orderBy('nombre')->get();
        $empresas = Empresa::orderBy('nombre')->get();
        $tutores  = Tutor::with('empresa')->orderBy('nombre')->get();

        return view('admin.practicas.create', compact('alumnos', 'empresas', 'tutores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'alumno_id'     => ['required', 'exists:alumnos,id'],
            'empresa_id'    => ['required', 'exists:empresas,id'],
            'tutor_id'      => ['nullable', 'exists:tutores,id'],
            'estado'        => ['required', 'string', 'max:50'],
            'fecha_inicio'  => ['required', 'date'],
            'fecha_fin'     => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ]);

        Practica::create($data);

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

    public function update(Request $request, Practica $practica)
    {
        $data = $request->validate([
            'alumno_id'     => ['required', 'exists:alumnos,id'],
            'empresa_id'    => ['required', 'exists:empresas,id'],
            'tutor_id'      => ['nullable', 'exists:tutores,id'],
            'estado'        => ['required', 'string', 'max:50'],
            'fecha_inicio'  => ['required', 'date'],
            'fecha_fin'     => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ]);

        $practica->update($data);

        return redirect()
            ->route('admin.practicas.index')
            ->with('success', 'Práctica actualizada correctamente.');
    }

    public function destroy(Practica $practica)
    {
        $practica->delete();

        return redirect()
            ->route('admin.practicas.index')
            ->with('success', 'Práctica eliminada correctamente.');
    }
}
