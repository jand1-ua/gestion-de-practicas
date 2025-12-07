<?php

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
        // Restricción: no eliminar si tiene prácticas asociadas
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
