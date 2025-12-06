<?php

namespace Tests\Feature;

use App\Models\Practica;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentPracticasTest extends TestCase
{
    use RefreshDatabase;

    public function test_practica_tiene_relaciones_con_alumno_empresa_y_tutor()
    {
        // Usamos los seeders de la BD
        $this->seed();

        $practica = Practica::with(['alumno', 'empresa', 'tutor'])->first();

        $this->assertNotNull($practica);
        $this->assertNotNull($practica->alumno);
        $this->assertNotNull($practica->empresa);
        $this->assertNotNull($practica->tutor);
    }
}
