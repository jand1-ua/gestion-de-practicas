<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ejecutar los seeders definidos en DatabaseSeeder.
     */
    protected bool $seed = true;

    /** Invitado intentando entrar en /admin -> debe ir a login */
    public function test_invitado_es_redirigido_a_login_cuando_intenta_acceder_al_area_admin(): void
    {
        $this->get('/admin/alumnos')
            ->assertRedirect(route('login'));
    }

    /** Un usuario admin puede acceder al área de administración */
    public function test_admin_puede_acceder_al_area_admin(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/alumnos');

        $response->assertStatus(200);
    }

    /** Un alumno autenticado NO puede entrar en /admin (403) */
    public function test_alumno_no_puede_acceder_al_area_admin(): void
    {
        $alumnoUser = User::factory()->create([
            'role' => 'alumno',
        ]);

        $response = $this->actingAs($alumnoUser)->get('/admin/alumnos');

        $response->assertStatus(403);
    }

    /** Un alumno con alumno_id asociado puede acceder a su área */
    public function test_alumno_puede_acceder_al_area_alumno(): void
    {
        // Alumno de prueba
        $alumno = Alumno::create([
            'nombre' => 'Alumno Test',
            'email'  => 'alumno.test@example.com',
            'grado'  => 'Ingeniería Informática',
            'curso'  => '4º',
        ]);

        // Usuario vinculado a ese alumno
        $user = User::factory()->create([
            'role'      => 'alumno',
            'alumno_id' => $alumno->id,
        ]);

        $response = $this->actingAs($user)->get(route('area.alumno'));

        $response->assertStatus(200);
        $response->assertSee('Área del alumno');
    }

    /** Un tutor con tutor_id asociado puede acceder a su área */
    public function test_tutor_puede_acceder_al_area_tutor(): void
    {
        // Empresa necesaria para el tutor (por la FK)
        $empresa = Empresa::create([
            'nombre'            => 'Empresa Test',
            'cif'               => 'B00000000',
            'sector'            => 'Tecnología',
            'ciudad'            => 'Alicante',
            'email_contacto'    => 'empresa@test.com',
            'telefono_contacto' => '900000000',
        ]);

        $tutor = Tutor::create([
            'empresa_id' => $empresa->id,
            'nombre'     => 'Tutor Test',
            'email'      => 'tutor.test@example.com',
            'telefono'   => '600000000',
        ]);

        $user = User::factory()->create([
            'role'     => 'tutor',
            'tutor_id' => $tutor->id,
        ]);

        $response = $this->actingAs($user)->get(route('area.tutor'));

        $response->assertStatus(200);
        $response->assertSee('Área del tutor');
    }

    /** Un admin NO puede entrar en el área de alumno (403 por middleware de rol) */
    public function test_admin_no_puede_acceder_al_area_alumno(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('area.alumno'));

        $response->assertStatus(403);
    }

    /** Un tutor NO puede entrar en el área de alumno (403) */
    public function test_tutor_no_puede_acceder_al_area_alumno(): void
    {
        $tutorUser = User::factory()->create([
            'role' => 'tutor',
        ]);

        $response = $this->actingAs($tutorUser)->get(route('area.alumno'));

        $response->assertStatus(403);
    }
}
