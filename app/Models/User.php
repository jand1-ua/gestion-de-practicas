<?php

namespace App\Models;

use App\Models\Alumno;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'alumno_id',
        'tutor_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    
    // Relación opcional con un alumno (si el usuario tiene rol "alumno").
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    
    // Relación opcional con un tutor (si el usuario tiene rol "tutor").
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }
}
