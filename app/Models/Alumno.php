<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'email',
        'grado',
        'curso',
    ];
    
    // Un alumno puede tener muchas prácticas.
     
    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class);
    }
}
