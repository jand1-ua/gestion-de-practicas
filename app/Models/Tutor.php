<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutor extends Model
{
    use HasFactory;

    protected $table = 'tutores';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'email',
        'telefono',
    ];

    // El tutor pertenece a una empresa.
     
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    // El tutor supervisa muchas prácticas.
     
    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class);
    }
}
