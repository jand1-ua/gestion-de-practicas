<?php

namespace Tests\Unit;

use App\Models\Alumno;
use App\Models\Practica;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumnoTest extends TestCase
{
    use RefreshDatabase;

    public function test_alumno_can_have_multiple_practicas(): void
    {
        $alumno = Alumno::factory()->create();
        Practica::factory(3)->create(['alumno_id' => $alumno->id]);

        $this->assertCount(3, $alumno->fresh()->practicas);
        $this->assertInstanceOf(Practica::class, $alumno->practicas->first());
    }

    public function test_alumno_email_must_be_unique(): void
    {
        Alumno::factory()->create(['email' => 'test@example.com']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        Alumno::factory()->create(['email' => 'test@example.com']);
    }
}
