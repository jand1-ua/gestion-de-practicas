<?php

namespace Tests\Feature;

use Tests\TestCase;

class DemoPracticasControllerTest extends TestCase
{
    public function test_pagina_alumnos_responde_ok()
    {
        $response = $this->get('/demo/alumnos');
        $response->assertStatus(200);
        $response->assertSee('Alumnos (demo)');
    }

    public function test_pagina_practicas_responde_ok()
    {
        $response = $this->get('/demo/practicas');
        $response->assertStatus(200);
        $response->assertSee('Prácticas (demo)');
    }
}
