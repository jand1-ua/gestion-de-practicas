<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TutorRequest;
use App\Models\Empresa;
use App\Models\Tutor;
use App\Services\PortalAccessService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TutorController extends Controller
{
    public function __construct(private readonly PortalAccessService $portalAccessService)
    {
    }

    public function index(): View
    {
        $search = trim((string) request('q', ''));

        $tutores = Tutor::with(['empresa', 'user'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('nombre', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('telefono', 'like', "%{$search}%")
                        ->orWhereHas('empresa', function ($empresaQuery) use ($search) {
                            $empresaQuery->where('nombre', 'like', "%{$search}%")
                                ->orWhere('sector', 'like', "%{$search}%")
                                ->orWhere('ciudad', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tutores.index', compact('tutores', 'search'));
    }

    public function create(): View
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('admin.tutores.create', compact('empresas'));
    }

    public function store(TutorRequest $request): RedirectResponse
    {
        $tutor = Tutor::create($request->validated());

        $redirect = redirect()
            ->route('admin.tutores.index')
            ->with('success', 'Tutor creado correctamente.');

        if ($request->boolean('create_portal_access', true)) {
            try {
                $credentials = $this->portalAccessService->createTutorAccess($tutor);

                return $redirect->with('portal_access', $credentials);
            } catch (DomainException $exception) {
                return $redirect->with('error', 'La ficha del tutor se creó, pero no se pudo generar el acceso al portal: ' . $exception->getMessage());
            }
        }

        return $redirect->with('info', 'La ficha del tutor se ha creado sin acceso al portal. Podrás generarlo más adelante desde la edición.');
    }

    public function show(Tutor $tutor): View
    {
        $tutor->load(['empresa', 'user']);

        return view('admin.tutores.show', compact('tutor'));
    }

    public function edit(Tutor $tutor): View
    {
        $tutor->load('user');
        $empresas = Empresa::orderBy('nombre')->get();

        return view('admin.tutores.edit', compact('tutor', 'empresas'));
    }

    public function update(TutorRequest $request, Tutor $tutor): RedirectResponse
    {
        $data = $request->validated();

        if ((int) $data['empresa_id'] !== (int) $tutor->empresa_id) {
            return redirect()
                ->route('admin.tutores.edit', $tutor)
                ->with('error', 'Este tutor ya está asignado a una empresa y no puede asignarse a otra.');
        }

        $tutor->update($data);
        $tutor->load('user');

        $redirect = redirect()
            ->route('admin.tutores.index')
            ->with('success', 'Tutor actualizado correctamente.');

        try {
            if ($tutor->user && $request->boolean('reset_portal_access')) {
                $credentials = $this->portalAccessService->createTutorAccess($tutor);

                return $redirect
                    ->with('portal_access', $credentials)
                    ->with('info', 'Se ha regenerado la contraseña temporal del tutor.');
            }

            if (! $tutor->user && $request->boolean('create_portal_access')) {
                $credentials = $this->portalAccessService->createTutorAccess($tutor);

                return $redirect
                    ->with('portal_access', $credentials)
                    ->with('info', 'Se ha creado el acceso al portal para el tutor.');
            }

            $this->portalAccessService->syncTutorAccess($tutor);
        } catch (DomainException $exception) {
            return $redirect->with('error', 'El tutor se actualizó, pero no se pudo sincronizar el acceso al portal: ' . $exception->getMessage());
        }

        return $redirect;
    }

    public function destroy(Tutor $tutor): RedirectResponse
    {
        if ($tutor->practicas()->exists()) {
            return redirect()
                ->route('admin.tutores.index')
                ->with('error', 'No se puede eliminar un tutor con prácticas asociadas.');
        }

        $this->portalAccessService->deleteTutorAccess($tutor);
        $tutor->delete();

        return redirect()
            ->route('admin.tutores.index')
            ->with('success', 'Tutor eliminado correctamente.');
    }
}
