<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_COORDINADOR = 'coordinador';
    public const ROLE_ALUMNO = 'alumno';
    public const ROLE_TUTOR = 'tutor';
    public const ROLE_ADMIN = 'admin';

    public const ROLES = [
        self::ROLE_COORDINADOR,
        self::ROLE_ALUMNO,
        self::ROLE_TUTOR,
        self::ROLE_ADMIN,
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'alumno_id',
        'tutor_id',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

    public static function coordinatorRoles(): array
    {
        return [self::ROLE_COORDINADOR, self::ROLE_ADMIN];
    }

    public static function roleLabels(): array
    {
        return [
            self::ROLE_COORDINADOR => 'Coordinador',
            self::ROLE_ALUMNO => 'Alumno',
            self::ROLE_TUTOR => 'Tutor',
            self::ROLE_ADMIN => 'Administrador',
        ];
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, self::coordinatorRoles(), true);
    }

    public function isAlumno(): bool
    {
        return $this->role === self::ROLE_ALUMNO;
    }

    public function isTutor(): bool
    {
        return $this->role === self::ROLE_TUTOR;
    }

    public function isCoordinator(): bool
    {
        return $this->role === self::ROLE_COORDINADOR || $this->role === self::ROLE_ADMIN;
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    public function mensajesEnviados(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'remitente_id');
    }

    public function mensajesRecibidos(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'destinatario_id');
    }

    public function roleLabel(): string
    {
        return self::roleLabels()[$this->role] ?? ucfirst((string) $this->role);
    }

    public function profileName(): string
    {
        $alumno = $this->relationLoaded('alumno') ? $this->alumno : null;
        $tutor = $this->relationLoaded('tutor') ? $this->tutor : null;

        $candidates = [];

        if ($this->isAlumno() && !empty($alumno?->nombre)) {
            $candidates[] = $alumno->nombre;
        }

        if ($this->isTutor() && !empty($tutor?->nombre)) {
            $candidates[] = $tutor->nombre;
        }

        $candidates[] = $this->name;
        $candidates[] = $this->email;
        $candidates[] = 'Usuario #' . $this->id;

        foreach ($candidates as $candidate) {
            $value = trim((string) $candidate);
            if ($value !== '') {
                return $value;
            }
        }

        return 'Usuario';
    }

    public function profileEmail(): string
    {
        $alumno = $this->relationLoaded('alumno') ? $this->alumno : null;
        $tutor = $this->relationLoaded('tutor') ? $this->tutor : null;

        $candidates = [];

        if ($this->isAlumno() && !empty($alumno?->email)) {
            $candidates[] = $alumno->email;
        }

        if ($this->isTutor() && !empty($tutor?->email)) {
            $candidates[] = $tutor->email;
        }

        $candidates[] = $this->email;

        foreach ($candidates as $candidate) {
            $value = trim((string) $candidate);
            if ($value !== '') {
                return $value;
            }
        }

        return '';
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->profileName();
    }

    public function getDisplayEmailAttribute(): string
    {
        return $this->profileEmail();
    }

    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->profileName(),
        );
    }

    protected function displayEmail(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->profileEmail(),
        );
    }
}
