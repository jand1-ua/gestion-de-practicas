<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            'sector'            => ['nullable', 'string', 'max:150'],
            'ciudad'            => ['nullable', 'string', 'max:100'],
            'email_contacto'    => ['nullable', 'email', 'max:150'],
            'telefono_contacto' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la empresa es obligatorio.',
            'cif.required'    => 'El CIF es obligatorio.',
            'cif.unique'      => 'Ya existe una empresa con ese CIF.',
            'email_contacto.email' => 'El email de contacto no es válido.',
        ];
    }
}
