<?php

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
