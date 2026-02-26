<?php

namespace App\Services\Practicas;

use App\Models\Mensaje;
use App\Models\Practica;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AsignarPracticaService
{
    public function asignar(array $data, ?User $coordinador = null): Practica
    {
        return DB::transaction(function () use ($data, $coordinador) {
            $tutor = Tutor::query()->findOrFail($data['tutor_id']);

            // Si no viene empresa_id, la inferimos del tutor.
            $data['empresa_id'] = $data['empresa_id'] ?? $tutor->empresa_id;

            if ((int) $data['empresa_id'] !== (int) $tutor->empresa_id) {
                throw new \InvalidArgumentException('La empresa debe coincidir con la empresa del tutor seleccionado.');
            }

            $practica = Practica::create($data);

            // Notificación interna (si existen usuarios vinculados)
            if ($coordinador) {
                $alumnoUser = User::query()->where('alumno_id', $practica->alumno_id)->first();
                $tutorUser  = User::query()->where('tutor_id', $practica->tutor_id)->first();

                $asunto = 'Nueva práctica asignada';
                $cuerpo = "Se ha asignado una nueva práctica (#{$practica->id}). "
                    . "Alumno: {$practica->alumno?->nombre}. "
                    . "Tutor: {$practica->tutor?->nombre}. "
                    . "Inicio: {$practica->fecha_inicio?->format('Y-m-d')}.";

                foreach ([$alumnoUser, $tutorUser] as $destinatario) {
                    if (! $destinatario) {
                        continue;
                    }

                    Mensaje::create([
                        'remitente_id'    => $coordinador->id,
                        'destinatario_id' => $destinatario->id,
                        'asunto'          => $asunto,
                        'cuerpo'          => $cuerpo,
                    ]);
                }
            }

            return $practica;
        });
    }
}
