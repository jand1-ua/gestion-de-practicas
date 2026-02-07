@extends('layouts.app')

@section('title', 'DB · Prácticas')

@section('content')
<div class="pagehead">
    <div>
        <h2>BD: prácticas</h2>
        <p>Listado obtenido con joins mediante Query Builder (facade DB).</p>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('db.alumnos') }}">Ver alumnos (BD)</a>
        <a class="btn" href="{{ route('sesiones') }}">Volver a sesiones</a>
    </div>
</div>

<div class="card">
    <div class="muted">Total: {{ $practicas->count() }}</div>

    <div class="table-wrap" style="margin-top:12px;">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Alumno</th>
                <th>Empresa</th>
                <th>Tutor</th>
                <th>Estado</th>
                <th>Inicio</th>
                <th>Fin</th>
            </tr>
            </thead>
            <tbody>
            @foreach($practicas as $practica)
                @php
                    $estado = $practica->estado;
                    $label = $estado === 'en_curso' ? 'En curso' : ucfirst($estado);
                    $badge = $estado === 'finalizada' ? 'badge-ok' : ($estado === 'pendiente' ? 'badge-warn' : 'badge-info');
                @endphp
                <tr>
                    <td class="muted">#{{ $practica->id }}</td>
                    <td><strong>{{ $practica->alumno }}</strong></td>
                    <td>{{ $practica->empresa }}</td>
                    <td>{{ $practica->tutor }}</td>
                    <td><span class="badge {{ $badge }}">{{ $label }}</span></td>
                    <td class="muted">{{ $practica->fecha_inicio }}</td>
                    <td class="muted">{{ $practica->fecha_fin ?? '—' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="code-panel" style="margin-top:16px;">
        <h3>Código (Sesión 3)</h3>
        <p>Acceso a datos con Query Builder: configuración BD, rutas, joins, migración y seeding.</p>

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
Route::get('/db/practicas', [DbPracticasController::class, 'practicas'])->name('db.practicas');

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

database/migrations/2025_12_06_092733_create_practicas_table.php
&lt;?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('practicas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumno_id')
                ->constrained('alumnos')
                ->restrictOnDelete();

            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->restrictOnDelete();

            $table->foreignId('tutor_id')
                ->constrained('tutores')
                ->restrictOnDelete();

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            $table->string('estado', 20)->default('pendiente');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practicas');
    }
};

database/seeders/PracticaSeeder.php
&lt;?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PracticaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('practicas')->insert([
            [
                'alumno_id' => 1,
                'empresa_id' => 1,
                'tutor_id' => 1,
                'fecha_inicio' => '2025-02-01',
                'fecha_fin' => '2025-06-30',
                'estado' => 'en_curso',
                'observaciones' => 'Prácticas de desarrollo web en Laravel.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'alumno_id' => 2,
                'empresa_id' => 2,
                'tutor_id' => 2,
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => null,
                'estado' => 'pendiente',
                'observaciones' => 'Pendiente de firma de convenio.',
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
