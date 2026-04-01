<?php

namespace App\Services\Practicas;

use App\Models\Mensaje;
use App\Models\Practica;
use App\Models\User;

class NotificarPracticaService
{
    public function notificarAsignacion(Practica $practica, User $coordinador): int
    {
        return $this->crearMensajes(
            $practica,
            $coordinador,
            'Nueva práctica asignada',
            'Se ha registrado una nueva práctica en el sistema.'
        );
    }

    public function notificarActualizacion(Practica $practica, User $coordinador): int
    {
        return $this->crearMensajes(
            $practica,
            $coordinador,
            'Práctica actualizada',
            'La información de una práctica ya registrada ha sido actualizada.'
        );
    }

    private function crearMensajes(Practica $practica, User $coordinador, string $asunto, string $intro): int
    {
        $practica->loadMissing(['alumno', 'empresa', 'tutor']);

        $destinatarios = User::query()
            ->where(function ($query) use ($practica) {
                $query->where(function ($roleQuery) use ($practica) {
                    $roleQuery->where('role', User::ROLE_ALUMNO)
                        ->where('alumno_id', $practica->alumno_id);
                })->orWhere(function ($roleQuery) use ($practica) {
                    $roleQuery->where('role', User::ROLE_TUTOR)
                        ->where('tutor_id', $practica->tutor_id);
                });
            })
            ->get();

        if ($destinatarios->isEmpty()) {
            return 0;
        }

        $cuerpo = $this->buildBody($practica, $intro);

        foreach ($destinatarios as $destinatario) {
            Mensaje::create([
                'remitente_id' => $coordinador->id,
                'destinatario_id' => $destinatario->id,
                'asunto' => $asunto,
                'cuerpo' => $cuerpo,
                'practica_id' => $practica->id,
            ]);
        }

        return $destinatarios->count();
    }

    private function buildBody(Practica $practica, string $intro): string
    {
        $inicio = $practica->fecha_inicio?->format('d/m/Y') ?? '—';
        $fin = $practica->fecha_fin?->format('d/m/Y') ?? 'Sin fecha definida';
        $estado = match ($practica->estado) {
            'en_curso' => 'En curso',
            'finalizada' => 'Finalizada',
            default => 'Pendiente',
        };

        $lineas = [
            $intro,
            '',
            'Alumno: ' . ($practica->alumno?->nombre ?? '—'),
            'Empresa: ' . ($practica->empresa?->nombre ?? '—'),
            'Tutor: ' . ($practica->tutor?->nombre ?? '—'),
            'Inicio: ' . $inicio,
            'Fin: ' . $fin,
            'Estado: ' . $estado,
        ];

        if ($practica->observaciones) {
            $lineas[] = 'Observaciones: ' . $practica->observaciones;
        }

        return implode("\n", $lineas);
    }
}
