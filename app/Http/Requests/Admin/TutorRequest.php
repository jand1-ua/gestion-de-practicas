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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->normalizeText($this->input('nombre')),
            'email' => $this->normalizeEmail($this->input('email')),
            'telefono' => $this->normalizePhone($this->input('telefono')),
        ]);
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
                Rule::unique('tutores', 'email')->ignore($tutorId),
            ],
            'telefono'   => ['required', 'regex:/^\+?[0-9]{9,15}$/'],
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
            'telefono.required'   => 'El teléfono es obligatorio.',
            'telefono.regex'      => 'El teléfono debe tener entre 9 y 15 dígitos y solo puede incluir un + inicial.',
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

    private function normalizePhone(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = preg_replace('/(?!^\+)\D+/', '', trim($value));

        return $normalized === '' ? null : $normalized;
    }
}
