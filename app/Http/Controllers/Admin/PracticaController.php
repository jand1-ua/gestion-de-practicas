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
        $practica->delete();

        return redirect()
            ->route('admin.practicas.index')
            ->with('success', 'Práctica eliminada correctamente.');
    }
}
