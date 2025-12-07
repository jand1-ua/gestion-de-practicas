<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::orderBy('id')->paginate(10);

        return view('admin.empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'            => 'required|string|max:150',
            'cif'               => 'required|string|max:20|unique:empresas,cif',
            'sector'            => 'nullable|string|max:150',
            'ciudad'            => 'nullable|string|max:100',
            'email_contacto'    => 'nullable|email|max:150',
            'telefono_contacto' => 'nullable|string|max:20',
        ]);

        Empresa::create($data);

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
         return view('admin.empresas.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        return view('admin.empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
        $data = $request->validate([
            'nombre'            => 'required|string|max:150',
            'cif'               => 'required|string|max:20|unique:empresas,cif,' . $empresa->id,
            'sector'            => 'nullable|string|max:150',
            'ciudad'            => 'nullable|string|max:100',
            'email_contacto'    => 'nullable|email|max:150',
            'telefono_contacto' => 'nullable|string|max:20',
        ]);

        $empresa->update($data);

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
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
