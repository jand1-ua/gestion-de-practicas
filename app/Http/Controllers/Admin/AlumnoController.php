<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AlumnoRequest;
use App\Models\Alumno;
use App\Services\PortalAccessService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AlumnoController extends Controller
{
    public function __construct(private readonly PortalAccessService $portalAccessService)
    {
    }

    public function index(): View
    {
        $search = trim((string) request('q', ''));

        $alumnos = Alumno::with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('nombre', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('grado', 'like', "%{$search}%")
                        ->orWhere('curso', 'like', "%{$search}%");
                });
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('admin.alumnos.index', compact('alumnos', 'search'));
    }

    public function create(): View
    {
        return view('admin.alumnos.create');
    }

    public function store(AlumnoRequest $request): RedirectResponse
    {
        $alumno = Alumno::create($request->validated());

        $redirect = redirect()
            ->route('admin.alumnos.index')
            ->with('success', 'Alumno creado correctamente.');

        if ($request->boolean('create_portal_access', true)) {
            try {
                $credentials = $this->portalAccessService->createAlumnoAccess($alumno);

                return $redirect->with('portal_access', $credentials);
            } catch (DomainException $exception) {
                return $redirect->with('error', 'La ficha del alumno se creó, pero no se pudo generar el acceso al portal: ' . $exception->getMessage());
            }
        }

        return $redirect->with('info', 'La ficha del alumno se ha creado sin acceso al portal. Podrás generarlo más adelante desde la edición.');
    }

    public function show(Alumno $alumno): View
    {
        $alumno->load('user');

        return view('admin.alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno): View
    {
        $alumno->load('user');

        return view('admin.alumnos.edit', compact('alumno'));
    }

    public function update(AlumnoRequest $request, Alumno $alumno): RedirectResponse
    {
        $alumno->update($request->validated());
        $alumno->load('user');

        $redirect = redirect()
            ->route('admin.alumnos.index')
            ->with('success', 'Alumno actualizado correctamente.');

        try {
            if ($alumno->user && $request->boolean('reset_portal_access')) {
                $credentials = $this->portalAccessService->createAlumnoAccess($alumno);

                return $redirect
                    ->with('portal_access', $credentials)
                    ->with('info', 'Se ha regenerado la contraseña temporal del alumno.');
            }

            if (! $alumno->user && $request->boolean('create_portal_access')) {
                $credentials = $this->portalAccessService->createAlumnoAccess($alumno);

                return $redirect
                    ->with('portal_access', $credentials)
                    ->with('info', 'Se ha creado el acceso al portal para el alumno.');
            }

            $this->portalAccessService->syncAlumnoAccess($alumno);
        } catch (DomainException $exception) {
            return $redirect->with('error', 'El alumno se actualizó, pero no se pudo sincronizar el acceso al portal: ' . $exception->getMessage());
        }

        return $redirect;
    }

    public function destroy(Alumno $alumno): RedirectResponse
    {
        if ($alumno->practicas()->exists()) {
            return redirect()
                ->route('admin.alumnos.index')
                ->with('error', 'No se puede eliminar un alumno con prácticas asociadas.');
        }

        $this->portalAccessService->deleteAlumnoAccess($alumno);
        $alumno->delete();

        return redirect()
            ->route('admin.alumnos.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }
}
