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

        return [
            'empresa_id' => ['required', 'exists:empresas,id'],
            'nombre'     => ['required', 'string', 'max:150'],
            'email'      => [
                'required',
                'email',
                'max:150',
                Rule::unique('tutores', 'email')->ignore($tutorId),
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
