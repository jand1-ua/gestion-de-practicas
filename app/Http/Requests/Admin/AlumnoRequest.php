<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $alumno = $this->route('alumno');
        $alumnoId = $alumno ? $alumno->id : null;

        return [
            'nombre' => ['required', 'string', 'max:150'],
            'email'  => [
                'required',
                'email',
                'max:150',
                Rule::unique('alumnos', 'email')->ignore($alumnoId),
            ],
            'grado'  => ['required', 'string', 'max:150'],
            'curso'  => ['required', 'string', 'max:10'], 
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required'  => 'El email es obligatorio.',
            'email.email'     => 'El email no tiene un formato válido.',
            'email.unique'    => 'Ya existe un alumno con ese email.',
            'grado.required'  => 'El grado es obligatorio.',
            'curso.required'  => 'El curso es obligatorio.',
        ];
    }
}
