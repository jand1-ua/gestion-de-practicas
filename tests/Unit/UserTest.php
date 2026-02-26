<?php

namespace Tests\Unit;

use App\Models\Alumno;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_admin_returns_true_for_coordinador(): void
    {
        $user = User::factory()->create(['role' => 'coordinador']);
        $this->assertTrue($user->isAdmin());
    }

    public function test_is_admin_returns_true_for_admin_legacy_role(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->assertTrue($user->isAdmin());
    }

    public function test_is_alumno_returns_true_for_alumno_role_and_relation_is_loaded(): void
    {
        $alumno = Alumno::factory()->create();

        $user = User::factory()->create([
            'role'      => 'alumno',
            'alumno_id' => $alumno->id,
        ]);

        $this->assertTrue($user->isAlumno());
        $this->assertInstanceOf(Alumno::class, $user->alumno);
    }

    public function test_is_tutor_returns_true_for_tutor_role_and_relation_is_loaded(): void
    {
        $tutor = Tutor::factory()->create();

        $user = User::factory()->create([
            'role'     => 'tutor',
            'tutor_id' => $tutor->id,
        ]);

        $this->assertTrue($user->isTutor());
        $this->assertInstanceOf(Tutor::class, $user->tutor);
    }
}
