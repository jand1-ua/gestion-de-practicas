<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    
    // Atributos asignables en masa. 
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       // 'admin', 'alumno', 'tutor'
        'alumno_id',  
        'tutor_id',   
    ];

    
    // Atributos ocultos para serialización.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    // Casts.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // -------------------------------------------------
    // Métodos de ayuda para roles
    // -------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAlumno(): bool
    {
        return $this->role === 'alumno';
    }

    public function isTutor(): bool
    {
        return $this->role === 'tutor';
    }

    // -------------------------------------------------
    // Relaciones con Alumno / Tutor
    // -------------------------------------------------

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    // -------------------------------------------------
    // Relaciones de mensajería
    // -------------------------------------------------

    public function mensajesEnviados(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'remitente_id');
    }

    public function mensajesRecibidos(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'destinatario_id');
    }
}
