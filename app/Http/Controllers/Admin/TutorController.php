<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\Empresa;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tutores = Tutor::with('empresa')
            ->orderBy('id')
            ->paginate(10);

        return view('admin.tutores.index', compact('tutores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('admin.tutores.create', compact('empresas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre'     => 'required|string|max:150',
            'email'      => 'required|email|max:150|unique:tutores,email',
            'telefono'   => 'nullable|string|max:20',
        ]);

        Tutor::create($data);

        return redirect()
            ->route('admin.tutores.index')
            ->with('success', 'Tutor creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tutor $tutor)
    {
        $tutor->load('empresa');

        return view('admin.tutores.show', compact('tutor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tutor $tutor)
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('admin.tutores.edit', compact('tutor', 'empresas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tutor $tutor)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre'     => 'required|string|max:150',
            'email'      => 'required|email|max:150|unique:tutores,email,' . $tutor->id,
            'telefono'   => 'nullable|string|max:20',
        ]);

        $tutor->update($data);

        return redirect()
            ->route('admin.tutores.index')
            ->with('success', 'Tutor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
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
