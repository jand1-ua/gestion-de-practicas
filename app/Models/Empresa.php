<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'nombre',
        'cif',
        'sector',
        'ciudad',
        'email_contacto',
        'telefono_contacto',
    ];

     
    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class);
    }
}
