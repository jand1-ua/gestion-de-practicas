<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Tutor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ejecutar DatabaseSeeder antes de cada test.
     *
     * DatabaseSeeder llamará a:
     *  - AlumnoSeeder
     *  - EmpresaSeeder
     *  - TutorSeeder
     *  - PracticaSeeder
     */
    protected $seed = true;

    public function test_alumnos_index_muestra_listado()
    {
        $response = $this->get(route('admin.alumnos.index'));

        $response->assertStatus(200);
        $response->assertSee('Ana García'); // del AlumnoSeeder
    }

    public function test_puede_crear_un_alumno_valido()
    {
        $response = $this->post(route('admin.alumnos.store'), [
            'nombre' => 'Alumno Test',
            'email'  => 'alumno.test@example.com',
            'grado'  => 'Ingeniería Informática',
            'curso'  => '2º',
        ]);

        $response->assertRedirect(route('admin.alumnos.index'));

        $this->assertDatabaseHas('alumnos', [
            'email' => 'alumno.test@example.com',
        ]);
    }

    public function test_no_permite_crear_alumno_sin_datos_obligatorios()
    {
        $response = $this->post(route('admin.alumnos.store'), []);

        $response->assertSessionHasErrors([
            'nombre',
            'email',
            'grado',
            'curso',
        ]);
    }

    public function test_empresas_index_muestra_listado()
    {
        $response = $this->get(route('admin.empresas.index'));

        $response->assertStatus(200);
        $response->assertSee('Tech Solutions S.L.'); // del EmpresaSeeder
    }

    public function test_puede_crear_una_empresa_valida()
    {
        $response = $this->post(route('admin.empresas.store'), [
            'nombre'            => 'Empresa Test S.L.',
            'cif'               => 'B00000001',
            'sector'            => 'Tecnología',
            'ciudad'            => 'Alicante',
            'email_contacto'    => 'contacto@testempresa.com',
            'telefono_contacto' => '600000000',
        ]);

        $response->assertRedirect(route('admin.empresas.index'));

        $this->assertDatabaseHas('empresas', [
            'cif' => 'B00000001',
        ]);
    }

    public function test_no_permite_crear_empresa_con_cif_duplicado()
    {
        // CIF del seeder: B12345678
        $response = $this->post(route('admin.empresas.store'), [
            'nombre'            => 'Otra empresa',
            'cif'               => 'B12345678',
            'sector'            => 'Formación',
            'ciudad'            => 'Elche',
            'email_contacto'    => 'otra@empresa.com',
            'telefono_contacto' => '600111222',
        ]);

        $response->assertSessionHasErrors(['cif']);
    }

    public function test_tutores_index_muestra_listado()
    {
        $response = $this->get(route('admin.tutores.index'));

        $response->assertStatus(200);
        $response->assertSee('Carlos Ruiz'); // del TutorSeeder
    }

    public function test_puede_crear_un_tutor_valido()
    {
        $empresa = Empresa::first();

        $response = $this->post(route('admin.tutores.store'), [
            'empresa_id' => $empresa->id,
            'nombre'     => 'Tutor Test',
            'email'      => 'tutor.test@empresa.com',
            'telefono'   => '600999888',
        ]);

        $response->assertRedirect(route('admin.tutores.index'));

        $this->assertDatabaseHas('tutores', [
            'email' => 'tutor.test@empresa.com',
        ]);
    }

    public function test_no_permite_crear_tutor_con_email_duplicado()
    {
        $empresa = Empresa::first();

        // Email del TutorSeeder: carlos.ruiz@techsolutions.com
        $response = $this->post(route('admin.tutores.store'), [
            'empresa_id' => $empresa->id,
            'nombre'     => 'Tutor Duplicado',
            'email'      => 'carlos.ruiz@techsolutions.com',
            'telefono'   => '600000000',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_practicas_index_muestra_listado()
    {
        $response = $this->get(route('admin.practicas.index'));

        $response->assertStatus(200);
        $response->assertSee('Prácticas de desarrollo web en Laravel.'); // del PracticaSeeder
    }

    public function test_puede_crear_una_practica_valida()
    {
        $alumno  = Alumno::first();
        $empresa = Empresa::first();
        $tutor   = Tutor::first();

        $response = $this->post(route('admin.practicas.store'), [
            'alumno_id'     => $alumno->id,
            'empresa_id'    => $empresa->id,
            'tutor_id'      => $tutor->id,
            'fecha_inicio'  => '2025-04-01',
            'fecha_fin'     => '2025-06-01',
            'estado'        => 'en_curso',
            'observaciones' => 'Práctica creada desde test.',
        ]);

        $response->assertRedirect(route('admin.practicas.index'));

        $this->assertDatabaseHas('practicas', [
            'alumno_id'  => $alumno->id,
            'empresa_id' => $empresa->id,
            'tutor_id'   => $tutor->id,
            'estado'     => 'en_curso',
        ]);
    }

    public function test_no_permite_crear_practica_con_fechas_incorrectas()
    {
        $alumno  = Alumno::first();
        $empresa = Empresa::first();
        $tutor   = Tutor::first();

        $response = $this->post(route('admin.practicas.store'), [
            'alumno_id'     => $alumno->id,
            'empresa_id'    => $empresa->id,
            'tutor_id'      => $tutor->id,
            'fecha_inicio'  => '2025-06-01',
            'fecha_fin'     => '2025-04-01', // fin antes que inicio
            'estado'        => 'en_curso',
            'observaciones' => 'Fechas mal.',
        ]);

        $response->assertSessionHasErrors(['fecha_fin']);
    }

    public function test_no_permite_crear_practica_con_estado_no_valido()
    {
        $alumno  = Alumno::first();
        $empresa = Empresa::first();
        $tutor   = Tutor::first();

        $response = $this->post(route('admin.practicas.store'), [
            'alumno_id'     => $alumno->id,
            'empresa_id'    => $empresa->id,
            'tutor_id'      => $tutor->id,
            'fecha_inicio'  => '2025-04-01',
            'fecha_fin'     => '2025-06-01',
            'estado'        => 'cualquier_cosa',
            'observaciones' => 'Estado erróneo.',
        ]);

        $response->assertSessionHasErrors(['estado']);
    }
}
