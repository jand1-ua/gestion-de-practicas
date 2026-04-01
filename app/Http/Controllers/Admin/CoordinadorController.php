<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoordinadorRequest;
use App\Models\User;
use App\Services\PortalAccessService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CoordinadorController extends Controller
{
    public function __construct(private readonly PortalAccessService $portalAccessService)
    {
    }

    public function index(): View
    {
        $search = trim((string) request('q', ''));

        $coordinadores = User::query()
            ->whereIn('role', User::coordinatorRoles())
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.coordinadores.index', compact('coordinadores', 'search'));
    }

    public function create(): View
    {
        return view('admin.coordinadores.create');
    }

    public function store(CoordinadorRequest $request): RedirectResponse
    {
        try {
            $credentials = $this->portalAccessService->createCoordinatorAccess(
                $request->validated('name'),
                $request->validated('email'),
            );

            return redirect()
                ->route('admin.coordinadores.index')
                ->with('success', 'Coordinador creado correctamente.')
                ->with('portal_access', $credentials);
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.coordinadores.index')
                ->with('error', 'No se pudo crear el coordinador: ' . $exception->getMessage());
        }
    }

    public function edit(User $coordinadore): View
    {
        if (! $coordinadore->isCoordinator()) {
            abort(404);
        }

        return view('admin.coordinadores.edit', ['coordinador' => $coordinadore]);
    }

    public function update(CoordinadorRequest $request, User $coordinadore): RedirectResponse
    {
        if (! $coordinadore->isCoordinator()) {
            abort(404);
        }

        try {
            $this->portalAccessService->updateCoordinatorAccess(
                $coordinadore,
                $request->validated('name'),
                $request->validated('email'),
            );

            $redirect = redirect()
                ->route('admin.coordinadores.index')
                ->with('success', 'Coordinador actualizado correctamente.');

            if ($request->boolean('reset_portal_access')) {
                $credentials = $this->portalAccessService->resetCoordinatorPassword($coordinadore);

                return $redirect
                    ->with('portal_access', $credentials)
                    ->with('info', 'Se ha regenerado la contraseña temporal del coordinador.');
            }

            return $redirect;
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.coordinadores.index')
                ->with('error', 'No se pudo actualizar el coordinador: ' . $exception->getMessage());
        }
    }

    public function destroy(User $coordinadore): RedirectResponse
    {
        if (! $coordinadore->isCoordinator()) {
            abort(404);
        }

        if ((int) $coordinadore->id === (int) Auth::id()) {
            return redirect()
                ->route('admin.coordinadores.index')
                ->with('error', 'No puedes eliminar tu propia cuenta de coordinación mientras estás autenticado.');
        }

        $count = User::query()->whereIn('role', User::coordinatorRoles())->count();
        if ($count <= 1) {
            return redirect()
                ->route('admin.coordinadores.index')
                ->with('error', 'Debe existir al menos una cuenta de coordinación activa en el sistema.');
        }

        $coordinadore->delete();

        return redirect()
            ->route('admin.coordinadores.index')
            ->with('success', 'Coordinador eliminado correctamente.');
    }
}
