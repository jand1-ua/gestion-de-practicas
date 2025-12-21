<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Practica;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    /**
     * Listado de mensajes (recibidos y enviados)
     */
    public function index()
    {
        $usuario = Auth::user();

        $recibidos = Mensaje::with('remitente')
            ->where('destinatario_id', $usuario->id)
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'recibidos_page');

        $enviados = Mensaje::with('destinatario')
            ->where('remitente_id', $usuario->id)
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'enviados_page');

        return view('mensajes.index', compact('usuario', 'recibidos', 'enviados'));
    }

    /**
     * Formulario de nuevo mensaje
     * - Filtra los destinatarios según el rol.
     * - Si viene ?destinatario_id=... (por “Responder”), lo preselecciona.
     */
    public function create(Request $request)
    {
        $usuario = Auth::user();
        $destinatarioId = $request->query('destinatario_id'); // usado al responder

        if ($usuario->role === 'coordinador') {

            // Coordinador puede escribir a cualquiera menos a sí mismo
            $destinatarios = User::where('id', '!=', $usuario->id)
                ->orderBy('name')
                ->get();

        } elseif ($usuario->role === 'alumno') {

            
            $coordinadores = User::where('role', 'coordinador')->get();

            // Tutores con los que el alumno tiene alguna práctica
            $tutorIds = Practica::where('alumno_id', $usuario->alumno_id)
                ->whereNotNull('tutor_id')
                ->pluck('tutor_id')
                ->unique()
                ->toArray();

            $tutores = empty($tutorIds)
                ? collect()
                : User::whereIn('tutor_id', $tutorIds)->get();

            $destinatarios = $coordinadores->merge($tutores)
                ->where('id', '!=', $usuario->id)
                ->unique('id')
                ->values();

        } elseif ($usuario->role === 'tutor') {

            $coordinadores = User::where('role', 'coordinador')->get();

            // Alumnos con los que el tutor tiene alguna práctica
            $alumnoIds = Practica::where('tutor_id', $usuario->tutor_id)
                ->pluck('alumno_id')
                ->unique()
                ->toArray();

            $alumnos = empty($alumnoIds)
                ? collect()
                : User::whereIn('alumno_id', $alumnoIds)->get();

            $destinatarios = $coordinadores->merge($alumnos)
                ->where('id', '!=', $usuario->id)
                ->unique('id')
                ->values();

        } else {
            // Cualquier otro rol: sólo permitir coordinadores
            $destinatarios = User::where('role', 'coordinador')
                ->where('id', '!=', $usuario->id)
                ->orderBy('name')
                ->get();
        }

        return view('mensajes.create', compact('usuario', 'destinatarios', 'destinatarioId'));
    }

    /**
     * Guarda un mensaje
     * - Valida campos.
     * - Si es conversación alumno–tutor, comprueba que tengan alguna práctica en común.
     */
    public function store(Request $request)
    {
        $usuario = Auth::user();

        $validated = $request->validate([
            'destinatario_id' => ['required', 'exists:users,id', 'not_in:'.$usuario->id],
            'asunto'          => ['nullable', 'string', 'max:255'],
            'cuerpo'          => ['required', 'string'],
        ]);

        $destinatario = User::findOrFail($validated['destinatario_id']);

        // ¿Es una comunicación alumno–tutor?
        $esAlumnoTutor =
            ($usuario->role === 'alumno' && $destinatario->role === 'tutor') ||
            ($usuario->role === 'tutor'  && $destinatario->role === 'alumno');

        if ($esAlumnoTutor) {
            $alumnoId = $usuario->role === 'alumno'
                ? $usuario->alumno_id
                : $destinatario->alumno_id;

            $tutorId = $usuario->role === 'tutor'
                ? $usuario->tutor_id
                : $destinatario->tutor_id;

            $compartenPractica = Practica::where('alumno_id', $alumnoId)
                ->where('tutor_id', $tutorId)
                ->exists();

            if (!$compartenPractica) {
                return back()
                    ->withErrors([
                        'destinatario_id' =>
                            'Sólo puedes enviar mensajes entre tutor y alumno cuando comparten al menos una práctica.',
                    ])
                    ->withInput();
            }
        }

        Mensaje::create([
            'remitente_id'    => $usuario->id,
            'destinatario_id' => $validated['destinatario_id'],
            'asunto'          => $validated['asunto'] ?? '',
            'cuerpo'          => $validated['cuerpo'],
        ]);

        return redirect()
            ->route('mensajes.index')
            ->with('success', 'Mensaje enviado correctamente.');
    }

    /**
     * Muestra un mensaje concreto
     * - Sólo remitente o destinatario lo pueden ver.
     * - Si soy destinatario, se marca como leído.
     */
    public function show(Mensaje $mensaje)
    {
        $usuario = Auth::user();

        if ($mensaje->remitente_id !== $usuario->id && $mensaje->destinatario_id !== $usuario->id) {
            abort(403);
        }

        if ($mensaje->destinatario_id === $usuario->id && is_null($mensaje->leido_en)) {
            $mensaje->update(['leido_en' => now()]);
        }

        $mensaje->load(['remitente', 'destinatario']);

        return view('mensajes.show', compact('usuario', 'mensaje'));
    }
}
