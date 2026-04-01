<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    public function scopeWithRelations(Builder $query): Builder
    {
        return $query->with(['alumno', 'empresa', 'tutor']);
    }

    public function scopeByEstado(Builder $query, string $estado): Builder
    {
        return $query->where('estado', $estado);
    }


    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $subquery) use ($search) {
            $subquery->where('estado', 'like', "%{$search}%")
                ->orWhere('observaciones', 'like', "%{$search}%")
                ->orWhereHas('alumno', function (Builder $alumnoQuery) use ($search) {
                    $alumnoQuery->where('nombre', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('empresa', function (Builder $empresaQuery) use ($search) {
                    $empresaQuery->where('nombre', 'like', "%{$search}%")
                        ->orWhere('sector', 'like', "%{$search}%")
                        ->orWhere('ciudad', 'like', "%{$search}%");
                })
                ->orWhereHas('tutor', function (Builder $tutorQuery) use ($search) {
                    $tutorQuery->where('nombre', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        });
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }
}
