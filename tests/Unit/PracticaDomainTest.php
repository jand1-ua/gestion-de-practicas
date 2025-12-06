<?php

namespace Tests\Unit;

use App\Domain\Alumno;
use App\Domain\Empresa;
use App\Domain\Practica;
use App\Domain\Tutor;
use DateTime;
use PHPUnit\Framework\TestCase;

class PracticaDomainTest extends TestCase
{
    public function test_calcula_duracion_y_estado()
    {
        $empresa = new Empresa(1, 'Tech', 'B123', 'Alicante', 'Tecnología');
        $tutor   = new Tutor(1, 'María', 'maria@tech.com', '600111222', $empresa);
        $alumno  = new Alumno(1, 'Ana', 'ana@example.com', 'ADE', 3);

        $inicio = new DateTime('2025-02-01');
        $fin    = new DateTime('2025-02-11');

        $practica = new Practica(1, $alumno, $empresa, $tutor, $inicio, $fin);

        $this->assertSame(10, $practica->getDuracionEnDias());

        $this->assertSame('pendiente', $practica->getEstado(new DateTime('2025-01-31')));
        $this->assertSame('en curso',  $practica->getEstado(new DateTime('2025-02-05')));
        $this->assertSame('finalizada', $practica->getEstado(new DateTime('2025-02-12')));
    }
}
