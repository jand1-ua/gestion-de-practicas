<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    public const SECTORES_DISPONIBLES = [
        'Tecnología',
        'Consultoría',
        'Industria',
        'Servicios',
        'Formación',
        'Sanidad',
        'Logística',
        'Finanzas',
        'Marketing y Comunicación',
        'Turismo y Hostelería',
    ];

    protected $table = 'empresas';

    protected $fillable = [
        'nombre',
        'cif',
        'sector',
        'ciudad',
        'email_contacto',
        'telefono_contacto',
    ];

    public static function sectoresDisponibles(): array
    {
        return self::SECTORES_DISPONIBLES;
    }

    public function tutores(): HasMany
    {
        return $this->hasMany(Tutor::class);
    }

    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class);
    }
}
