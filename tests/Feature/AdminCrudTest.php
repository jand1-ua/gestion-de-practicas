<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Practica;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private ?User $coordinador = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->coordinador = User::factory()->create([
            'role'  => 'coordinador',
            'email' => 'coordinador@example.com',
        ]);

        $ana = Alumno::factory()->create([
            'nombre' => 'Ana García',
            'email'  => 'ana.garcia@example.com',
            'grado'  => 'Ingeniería Informática',
            'curso'  => '4º',
        ]);

        $luis = Alumno::factory()->create([
            'nombre' => 'Luis Pérez',
            'email'  => 'luis.perez@example.com',
            'grado'  => 'Ingeniería Informática',
            'curso'  => '3º',
        ]);

        $tech = Empresa::factory()->create([
            'nombre'            => 'Tech Solutions S.L.',
            'cif'               => 'B12345678',
            'sector'            => 'Tecnología',
            'ciudad'            => 'Alicante',
            'email_contacto'    => 'contacto@techsolutions.com',
            'telefono_contacto' => '965000111',
        ]);

        $soft = Empresa::factory()->create([
            'nombre'            => 'SoftEdu S.A.',
            'cif'               => 'A87654321',
            'sector'            => 'Formación',
            'ciudad'            => 'Elche',
            'email_contacto'    => 'info@softedu.com',
            'telefono_contacto' => '966111222',
        ]);

        $tutorTech = Tutor::factory()->create([
            'empresa_id' => $tech->id,
            'nombre'     => 'Carlos Ruiz',
            'email'      => 'carlos.ruiz@techsolutions.com',
            'telefono'   => '600111222',
        ]);

        $tutorSoft = Tutor::factory()->create([
            'empresa_id' => $soft->id,
            'nombre'     => 'Elena Martínez',
            'email'      => 'elena.martinez@softedu.com',
            'telefono'   => '600333444',
        ]);

        Practica::factory()->create([
            'alumno_id'     => $ana->id,
            'empresa_id'    => $tech->id,
            'tutor_id'      => $tutorTech->id,
            'fecha_inicio'  => '2025-02-01',
            'fecha_fin'     => '2025-06-30',
            'estado'        => 'en_curso',
            'observaciones' => 'Prácticas de desarrollo web en Laravel.',
        ]);

        Practica::factory()->create([
            'alumno_id'     => $luis->id,
            'empresa_id'    => $soft->id,
            'tutor_id'      => $tutorSoft->id,
            'fecha_inicio'  => '2025-03-01',
            'fecha_fin'     => null,
            'estado'        => 'pendiente',
            'observaciones' => 'Pendiente de firma de convenio.',
        ]);
    }

    public function test_alumnos_index_muestra_listado()
    {
        $response = $this->actingAs($this->coordinador)->get(route('admin.alumnos.index'));

        $response->assertStatus(200);
        $response->assertSee('Ana García'); 
    }

    public function test_puede_crear_un_alumno_valido()
    {
        $response = $this->actingAs($this->coordinador)->post(route('admin.alumnos.store'), [
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
        $response = $this->actingAs($this->coordinador)->post(route('admin.alumnos.store'), []);

        $response->assertSessionHasErrors([
            'nombre',
            'email',
            'grado',
            'curso',
        ]);
    }

    public function test_empresas_index_muestra_listado()
    {
        $response = $this->actingAs($this->coordinador)->get(route('admin.empresas.index'));

        $response->assertStatus(200);
        $response->assertSee('Tech Solutions S.L.'); 
    }

    public function test_puede_crear_una_empresa_valida()
    {
        $response = $this->actingAs($this->coordinador)->post(route('admin.empresas.store'), [
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
        $response = $this->actingAs($this->coordinador)->post(route('admin.empresas.store'), [
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
        $response = $this->actingAs($this->coordinador)->get(route('admin.tutores.index'));

        $response->assertStatus(200);
        $response->assertSee('Carlos Ruiz'); 
    }

    public function test_puede_crear_un_tutor_valido()
    {
        $empresa = Empresa::where('cif', 'B12345678')->first();

        $response = $this->actingAs($this->coordinador)->post(route('admin.tutores.store'), [
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
        $empresa = Empresa::where('cif', 'B12345678')->first();

        $response = $this->actingAs($this->coordinador)->post(route('admin.tutores.store'), [
            'empresa_id' => $empresa->id,
            'nombre'     => 'Tutor Duplicado',
            'email'      => 'carlos.ruiz@techsolutions.com',
            'telefono'   => '600000000',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_practicas_index_muestra_listado()
    {
        $response = $this->actingAs($this->coordinador)->get(route('admin.practicas.index'));

        $response->assertStatus(200);
        $response->assertSee('Prácticas de desarrollo web en Laravel.'); 
    }

    public function test_puede_crear_una_practica_valida()
    {
        $alumno  = Alumno::where('email', 'ana.garcia@example.com')->first();
        $empresa = Empresa::where('cif', 'B12345678')->first();
        $tutor   = Tutor::where('email', 'carlos.ruiz@techsolutions.com')->first();

        $response = $this->actingAs($this->coordinador)->post(route('admin.practicas.store'), [
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
        $alumno  = Alumno::where('email', 'ana.garcia@example.com')->first();
        $empresa = Empresa::where('cif', 'B12345678')->first();
        $tutor   = Tutor::where('email', 'carlos.ruiz@techsolutions.com')->first();

        $response = $this->actingAs($this->coordinador)->post(route('admin.practicas.store'), [
            'alumno_id'     => $alumno->id,
            'empresa_id'    => $empresa->id,
            'tutor_id'      => $tutor->id,
            'fecha_inicio'  => '2025-06-01',
            'fecha_fin'     => '2025-04-01', 
            'estado'        => 'en_curso',
            'observaciones' => 'Fechas mal.',
        ]);

        $response->assertSessionHasErrors(['fecha_fin']);
    }

    public function test_no_permite_crear_practica_con_estado_no_valido()
    {
        $alumno  = Alumno::where('email', 'ana.garcia@example.com')->first();
        $empresa = Empresa::where('cif', 'B12345678')->first();
        $tutor   = Tutor::where('email', 'carlos.ruiz@techsolutions.com')->first();

        $response = $this->actingAs($this->coordinador)->post(route('admin.practicas.store'), [
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

    public function test_filtrar_practicas_por_estado_pendiente()
    {
        $response = $this->actingAs($this->coordinador)->get(route('admin.practicas.index', [
            'estado' => 'pendiente',
        ]));

        $response->assertStatus(200);

        $response->assertSee('Pendiente de firma de convenio.');

        $response->assertDontSee('Prácticas de desarrollo web en Laravel.');
    }
}
