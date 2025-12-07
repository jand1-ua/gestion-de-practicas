<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnos = Alumno::orderBy('id')->paginate(10);

        return view('admin.alumnos.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.alumnos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'email'  => 'required|email|max:150|unique:alumnos,email',
            'grado'  => 'nullable|string|max:100',
            'curso'  => 'nullable|string|max:50',
        ]);

        Alumno::create($data);

        return redirect()
            ->route('admin.alumnos.index')
            ->with('success', 'Alumno creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        // En esta iteración mostramos solo sus datos básicos.
        return view('admin.alumnos.show', compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumno $alumno)
    {
        return view('admin.alumnos.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'email'  => 'required|email|max:150|unique:alumnos,email,' . $alumno->id,
            'grado'  => 'nullable|string|max:100',
            'curso'  => 'nullable|string|max:50',
        ]);

        $alumno->update($data);

        return redirect()
            ->route('admin.alumnos.index')
            ->with('success', 'Alumno actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        // Restricción típica: no borrar si tiene prácticas asociadas
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
