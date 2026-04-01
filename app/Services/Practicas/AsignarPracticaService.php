<?php

namespace App\Services\Practicas;

use App\Models\Practica;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AsignarPracticaService
{
    public function __construct(private readonly NotificarPracticaService $notificarPracticaService)
    {
    }

    public function asignar(array $data, ?User $coordinador = null): Practica
    {
        return DB::transaction(function () use ($data, $coordinador) {
            $tutor = Tutor::query()->findOrFail($data['tutor_id']);

            $data['empresa_id'] = $data['empresa_id'] ?? $tutor->empresa_id;

            if ((int) $data['empresa_id'] !== (int) $tutor->empresa_id) {
                throw new \InvalidArgumentException('La empresa debe coincidir con la empresa del tutor seleccionado.');
            }

            $practica = Practica::create($data);

            if ($coordinador) {
                $this->notificarPracticaService->notificarAsignacion($practica, $coordinador);
            }

            return $practica;
        });
    }
}
