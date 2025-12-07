<?php

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
