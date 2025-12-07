<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PracticaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Estados que se usan en los seeders: en_curso, pendiente y finalizada.
        $estados = ['en_curso', 'pendiente', 'finalizada'];

        $practica = $this->route('practica');
        $practicaId = $practica ? $practica->id : null;

        return [
            'alumno_id'     => ['required', 'exists:alumnos,id'],
            'empresa_id'    => ['required', 'exists:empresas,id'],
            'tutor_id'      => ['required', 'exists:tutores,id'],
            'fecha_inicio'  => ['required', 'date'],
            'fecha_fin'     => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'estado'        => ['required', 'string', Rule::in($estados)],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'alumno_id.required'   => 'Debes seleccionar un alumno.',
            'alumno_id.exists'     => 'El alumno seleccionado no existe.',
            'empresa_id.required'  => 'Debes seleccionar una empresa.',
            'empresa_id.exists'    => 'La empresa seleccionada no existe.',
            'tutor_id.required'    => 'Debes seleccionar un tutor.',
            'tutor_id.exists'      => 'El tutor seleccionado no existe.',
            'fecha_inicio.required'=> 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date'    => 'La fecha de inicio no es válida.',
            'fecha_fin.date'       => 'La fecha de fin no es válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la de inicio.',
            'estado.required'      => 'El estado es obligatorio.',
            'estado.in'            => 'El estado seleccionado no es válido.',
        ];
    }
}
