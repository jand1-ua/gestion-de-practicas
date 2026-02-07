<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tutor = $this->route('tutor');
        $tutorId = $tutor ? $tutor->id : null;

        $empresaRule = ['required', 'exists:empresas,id'];

        if ($tutor) {
            $empresaRule[] = function ($attribute, $value, $fail) use ($tutor) {
                if ((int) $value !== (int) $tutor->empresa_id) {
                    $fail('Este tutor ya está asignado a una empresa y no puede asignarse a otra.');
                }
            };
        }

        return [
            'empresa_id' => $empresaRule,
            'nombre'     => ['required', 'string', 'max:150'],
            'email'      => [
                'required',
                'email',
                'max:150',
                \Illuminate\Validation\Rule::unique('tutores', 'email')->ignore($tutorId),
            ],
            'telefono'   => ['nullable', 'string', 'max:20'],
        ];
    }


    public function messages(): array
    {
        return [
            'empresa_id.required' => 'Debes seleccionar una empresa.',
            'empresa_id.exists'   => 'La empresa seleccionada no existe.',
            'nombre.required'     => 'El nombre del tutor es obligatorio.',
            'email.required'      => 'El email es obligatorio.',
            'email.email'         => 'El email no es válido.',
            'email.unique'        => 'Ya existe un tutor con ese email.',
        ];
    }
}
