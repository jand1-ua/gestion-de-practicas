<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\Practica;

class MensajeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'destinatario_id' => ['required', 'integer', 'exists:users,id'],
            'asunto'          => ['nullable', 'string', 'max:150'],
            'contenido'       => ['required', 'string', 'min:5'],
            'practica_id'     => ['nullable', 'integer', 'exists:practicas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'destinatario_id.required' => 'Debes seleccionar un destinatario.',
            'destinatario_id.exists'   => 'El destinatario seleccionado no es válido.',
            'contenido.required'       => 'El contenido del mensaje es obligatorio.',
            'contenido.min'            => 'El mensaje debe tener al menos :min caracteres.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $user = $this->user();
            if (!$user) {
                return;
            }

            $destId = $this->input('destinatario_id');
            if (!$destId) {
                return;
            }

            $dest = User::find($destId);
            if (!$dest) {
                return;
            }

            if ($user->isAdmin()) {
                if (!in_array($dest->role, ['alumno', 'tutor'])) {
                    $validator->errors()->add(
                        'destinatario_id',
                        'El administrador solo puede enviar mensajes a alumnos o tutores.'
                    );
                }
                return;
            }

            if (in_array($user->role, ['alumno', 'tutor']) && $dest->isAdmin()) {
                return;
            }

            if ($user->isAlumno() && $dest->isTutor()) {
                $exists = Practica::where('alumno_id', $user->alumno_id)
                    ->where('tutor_id', $dest->tutor_id)
                    ->exists();

                if (!$exists) {
                    $validator->errors()->add(
                        'destinatario_id',
                        'No existe ninguna práctica que vincule a este alumno con el tutor seleccionado.'
                    );
                }
                return;
            }

            if ($user->isTutor() && $dest->isAlumno()) {
                $exists = Practica::where('alumno_id', $dest->alumno_id)
                    ->where('tutor_id', $user->tutor_id)
                    ->exists();

                if (!$exists) {
                    $validator->errors()->add(
                        'destinatario_id',
                        'No existe ninguna práctica que vincule a este tutor con el alumno seleccionado.'
                    );
                }
                return;
            }

            $validator->errors()->add(
                'destinatario_id',
                'No está permitido enviar mensajes a este tipo de usuario.'
            );
        });
    }
}
