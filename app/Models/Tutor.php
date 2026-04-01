<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
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