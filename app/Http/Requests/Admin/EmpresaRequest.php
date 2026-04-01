<?php

namespace App\Http\Requests\Admin;

use App\Models\Empresa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->normalizeText($this->input('nombre')),
            'cif' => $this->normalizeCif($this->input('cif')),
            'sector' => $this->normalizeText($this->input('sector')),
            'ciudad' => $this->normalizeText($this->input('ciudad')),
            'email_contacto' => $this->normalizeEmail($this->input('email_contacto')),
            'telefono_contacto' => $this->normalizePhone($this->input('telefono_contacto')),
        ]);
    }

    public function rules(): array
    {
        $empresa = $this->route('empresa');
        $empresaId = $empresa ? $empresa->id : null;

        return [
            'nombre'            => ['required', 'string', 'max:150'],
            'cif'               => [
                'required',
                'string',
                'max:20',
                Rule::unique('empresas', 'cif')->ignore($empresaId),
            ],
            'sector'            => ['required', 'string', Rule::in(Empresa::sectoresDisponibles())],
            'ciudad'            => ['required', 'string', 'max:100'],
            'email_contacto'    => ['required', 'email', 'max:150'],
            'telefono_contacto' => ['required', 'regex:/^\+?[0-9]{9,15}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la empresa es obligatorio.',
            'cif.required'    => 'El CIF es obligatorio.',
            'cif.unique'      => 'Ya existe una empresa con ese CIF.',
            'sector.required' => 'Debes seleccionar un sector.',
            'sector.in'       => 'Debes seleccionar un sector de la lista.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'email_contacto.required' => 'El email de contacto es obligatorio.',
            'email_contacto.email' => 'El email de contacto no es válido.',
            'telefono_contacto.required' => 'El teléfono de contacto es obligatorio.',
            'telefono_contacto.regex' => 'El teléfono de contacto debe tener entre 9 y 15 dígitos y solo puede incluir un + inicial.',
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

    private function normalizeCif(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return strtoupper(trim($value));
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
