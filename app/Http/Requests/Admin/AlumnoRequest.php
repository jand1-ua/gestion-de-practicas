<?php

namespace App\Http\Requests\Admin;

use App\Models\Alumno;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->normalizeText($this->input('nombre')),
            'email' => $this->normalizeEmail($this->input('email')),
            'grado' => $this->normalizeText($this->input('grado')),
            'curso' => $this->normalizeText($this->input('curso')),
        ]);
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
            'grado'  => ['required', 'string', Rule::in(Alumno::gradosDisponibles())],
            'curso'  => ['required', 'string', Rule::in(Alumno::cursosDisponibles())],
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
            'grado.in'        => 'Debes seleccionar un grado de la lista.',
            'curso.required'  => 'El curso es obligatorio.',
            'curso.in'        => 'Debes seleccionar un curso de la lista.',
        ];
    }

    private function normalizeText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return trim(preg_replace('/\s+/u', ' ', $value));
    }

    private function normalizeEmail(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return mb_strtolower(trim($value));
    }
}
