<?php

use App\Http\Controllers\Admin\AlumnoController as AdminAlumnoController;
use App\Http\Controllers\Admin\CoordinadorController;
use App\Http\Controllers\Admin\EmpresaController as AdminEmpresaController;
use App\Http\Controllers\Admin\PracticaController;
use App\Http\Controllers\Admin\TutorController as AdminTutorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordSetupController;
use App\Http\Controllers\MensajeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

/*
|--------------------------------------------------------------------------
| Rutas heredadas de las sesiones de clase
|--------------------------------------------------------------------------
| Se redirigen al inicio para que la aplicación muestre únicamente
| el flujo funcional final y no pantallas de demostración docente.
*/
Route::get('/sesiones', function () {
    return to_route('home')->with('info', 'El índice de sesiones ya no forma parte de la versión final de la aplicación.');
})->name('sesiones');

Route::prefix('demo')->group(function () {
    Route::get('/alumnos', fn () => to_route('home'));
    Route::get('/practicas', fn () => to_route('home'));
});

Route::prefix('db')->group(function () {
    Route::get('/alumnos', fn () => to_route('home'));
    Route::get('/practicas', fn () => to_route('home'));
});

Route::prefix('eloquent')->group(function () {
    Route::get('/alumnos', fn () => to_route('home'));
    Route::get('/practicas', fn () => to_route('home'));
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/password/setup', [PasswordSetupController::class, 'edit'])->name('password.setup.edit');
    Route::put('/password/setup', [PasswordSetupController::class, 'update'])->name('password.setup.update');
});

Route::middleware(['auth', 'force.password.change', 'role:coordinador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.practicas.index');
        })->name('dashboard');

        Route::resource('coordinadores', CoordinadorController::class)
            ->except(['show'])
            ->parameters(['coordinadores' => 'coordinadore']);
        Route::resource('alumnos', AdminAlumnoController::class);
        Route::resource('empresas', AdminEmpresaController::class);
        Route::resource('tutores', AdminTutorController::class)
            ->parameters(['tutores' => 'tutor']);
        Route::resource('practicas', PracticaController::class)
            ->names('practicas');
    });

Route::middleware(['auth', 'force.password.change', 'role:alumno'])
    ->get('/area/alumno', function () {
        $user = Auth::user();
        $alumno = $user->alumno()
            ->with(['practicas' => function ($query) {
                $query->with(['empresa', 'tutor'])->orderByDesc('fecha_inicio');
            }])
            ->first();

        return view('areas.alumno', compact('user', 'alumno'));
    })
    ->name('area.alumno');

Route::middleware(['auth', 'force.password.change', 'role:tutor'])
    ->get('/area/tutor', function () {
        $user = Auth::user();
        $tutor = $user->tutor()
            ->with(['empresa', 'practicas' => function ($query) {
                $query->with(['alumno', 'empresa'])->orderByDesc('fecha_inicio');
            }])
            ->first();

        return view('areas.tutor', compact('user', 'tutor'));
    })
    ->name('area.tutor');

Route::middleware(['auth', 'force.password.change', 'role:coordinador'])
    ->get('/area/coordinador', function () {
        return redirect()->route('admin.dashboard');
    })
    ->name('area.coordinador');

Route::middleware(['auth', 'force.password.change'])->group(function () {
    Route::resource('mensajes', MensajeController::class)
        ->only(['index', 'create', 'store', 'show'])
        ->names('mensajes');
});
