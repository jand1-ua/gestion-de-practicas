<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmpresaRequest;
use App\Models\Empresa;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmpresaController extends Controller
{
    public function index(): View
    {
        $search = trim((string) request('q', ''));

        $empresas = Empresa::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('nombre', 'like', "%{$search}%")
                        ->orWhere('cif', 'like', "%{$search}%")
                        ->orWhere('sector', 'like', "%{$search}%")
                        ->orWhere('ciudad', 'like', "%{$search}%")
                        ->orWhere('email_contacto', 'like', "%{$search}%")
                        ->orWhere('telefono_contacto', 'like', "%{$search}%");
                });
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('admin.empresas.index', compact('empresas', 'search'));
    }

    public function create(): View
    {
        return view('admin.empresas.create');
    }

    public function store(EmpresaRequest $request): RedirectResponse
    {
        Empresa::create($request->validated());

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa creada correctamente.');
    }

    public function show(Empresa $empresa): View
    {
        return view('admin.empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa): View
    {
        return view('admin.empresas.edit', compact('empresa'));
    }

    public function update(EmpresaRequest $request, Empresa $empresa): RedirectResponse
    {
        $empresa->update($request->validated());

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa actualizada correctamente.');
    }

    public function destroy(Empresa $empresa): RedirectResponse
    {
        if ($empresa->practicas()->exists()) {
            return redirect()
                ->route('admin.empresas.index')
                ->with('error', 'No se puede eliminar una empresa con prácticas asociadas.');
        }

        if ($empresa->tutores()->exists()) {
            return redirect()
                ->route('admin.empresas.index')
                ->with('error', 'No se puede eliminar una empresa con tutores asociados. Elimina o reasigna antes sus tutores.');
        }

        $empresa->delete();

        return redirect()
            ->route('admin.empresas.index')
            ->with('success', 'Empresa eliminada correctamente.');
    }
}
