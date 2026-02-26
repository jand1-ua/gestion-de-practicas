<?php

namespace Tests\Unit;

use App\Models\Empresa;
use App\Models\Practica;
use App\Models\Tutor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmpresaTest extends TestCase
{
    use RefreshDatabase;

    public function test_empresa_can_have_multiple_tutores(): void
    {
        $empresa = Empresa::factory()->create();
        Tutor::factory(3)->create(['empresa_id' => $empresa->id]);

        $this->assertCount(3, $empresa->fresh()->tutores);
    }

    public function test_empresa_can_have_multiple_practicas(): void
    {
        $empresa = Empresa::factory()->create();
        $tutor = Tutor::factory()->create(['empresa_id' => $empresa->id]);

        Practica::factory(2)->create([
            'empresa_id' => $empresa->id,
            'tutor_id'   => $tutor->id,
        ]);

        $this->assertCount(2, $empresa->fresh()->practicas);
    }
}
