<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Practica extends Model
{
    use HasFactory;

    protected $table = 'practicas';

    protected $fillable = [
        'alumno_id',
        'empresa_id',
        'tutor_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'observaciones',
    ];

    
    // La práctica pertenece a un alumno.
    
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    
    // La práctica pertenece a una empresa.
     
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    // La práctica pertenece a un tutor.
     
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }
}
