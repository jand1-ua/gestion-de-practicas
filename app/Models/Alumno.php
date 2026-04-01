<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alumno extends Model
{
    use HasFactory;

    public const GRADOS_DISPONIBLES = [
        'Ingeniería Informática',
        'Ingeniería Industrial',
        'Administración de Empresas',
        'Marketing',
        'Turismo',
        'Relaciones Laborales y Recursos Humanos',
        'Matemáticas',
        'Máster en Ingeniería Informática',
    ];

    public const CURSOS_DISPONIBLES = [
        '1º',
        '2º',
        '3º',
        '4º',
        'Máster',
    ];

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'email',
        'grado',
        'curso',
    ];

    public static function gradosDisponibles(): array
    {
        return self::GRADOS_DISPONIBLES;
    }

    public static function cursosDisponibles(): array
    {
        return self::CURSOS_DISPONIBLES;
    }

    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}