@extends('layouts.app')

@section('title', 'DB · Alumnos')

@section('content')
<div class="pagehead">
    <div>
        <h2>BD: alumnos</h2>
        <p>Listado obtenido con Query Builder (facade DB).</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('db.practicas') }}">Ver prácticas (BD)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ $alumnos->count() }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Grado</th>
                    <th>Curso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                    <tr>
                        <td class="muted">#{{ $alumno->id }}</td>
                        <td><strong>{{ $alumno->nombre }}</strong></td>
                        <td class="muted">{{ $alumno->email }}</td>
                        <td>{{ $alumno->grado }}</td>
                        <td>{{ $alumno->curso }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="code-panel" style="margin-top:16px;">
        <h3>Código (Sesión 3)</h3>
        <p>Acceso a datos con Query Builder: configuración BD, rutas, consulta, migración y seeding.</p>

        <div class="code-block">
            <pre><code>@verbatim
.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_practicas
DB_USERNAME=laravel
DB_PASSWORD=laravel123

routes/web.php
use App\Http\Controllers\DbPracticasController;
Route::get('/db/alumnos', [DbPracticasController::class, 'alumnos'])->name('db.alumnos');

app/Http/Controllers/DbPracticasController.php
&lt;?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DbPracticasController extends Controller
{
    public function alumnos()
    {
        $alumnos = DB::table('alumnos')
            ->orderBy('nombre')
            ->get();

        return view('db.alumnos', [
            'alumnos' => $alumnos,
        ]);
    }

    public function practicas()
    {
        $practicas = DB::table('practicas')
            ->join('alumnos', 'practicas.alumno_id', '=', 'alumnos.id')
            ->join('empresas', 'practicas.empresa_id', '=', 'empresas.id')
            ->join('tutores', 'practicas.tutor_id', '=', 'tutores.id')
            ->select(
                'practicas.id',
                'alumnos.nombre as alumno',
                'empresas.nombre as empresa',
                'tutores.nombre as tutor',
                'practicas.estado',
                'practicas.fecha_inicio',
                'practicas.fecha_fin'
            )
            ->orderBy('practicas.id')
            ->get();

        return view('db.practicas', [
            'practicas' => $practicas,
        ]);
    }
}

database/migrations/2025_12_06_091041_create_alumnos_table.php
&lt;?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('grado')->nullable();
            $table->string('curso')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};

database/seeders/AlumnoSeeder.php
&lt;?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alumnos')->insert([
            [
                'nombre' => 'Ana García',
                'email' => 'ana.garcia@example.com',
                'grado' => 'Ingeniería Informática',
                'curso' => '4º',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luis Pérez',
                'email' => 'luis.perez@example.com',
                'grado' => 'Ingeniería Informática',
                'curso' => '3º',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María López',
                'email' => 'maria.lopez@example.com',
                'grado' => 'Ingeniería Informática',
                'curso' => '4º',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

database/seeders/DatabaseSeeder.php
&lt;?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AlumnoSeeder::class,
            EmpresaSeeder::class,
            TutorSeeder::class,
            PracticaSeeder::class,
            UserSeeder::class,
        ]);
    }
}
@endverbatim</code></pre>
        </div>
    </div>
</div>
@endsection
