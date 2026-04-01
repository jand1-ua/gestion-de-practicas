<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoordinadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->normalizeText($this->input('name')),
            'email' => $this->normalizeEmail($this->input('email')),
        ]);
    }

    public function rules(): array
    {
        $user = $this->route('coordinadore');
        $userId = $user?->id;

        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del coordinador es obligatorio.',
            'email.required' => 'El email de acceso es obligatorio.',
            'email.email' => 'El email no tiene un formato válido.',
            'email.unique' => 'Ya existe otra cuenta de acceso con ese email.',
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
