<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Practica;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $recibidos = Mensaje::with(['remitente.alumno', 'remitente.tutor', 'practica.alumno'])
            ->where('destinatario_id', $usuario->id)
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'recibidos_page');

        $enviados = Mensaje::with(['destinatario.alumno', 'destinatario.tutor', 'practica.alumno'])
            ->where('remitente_id', $usuario->id)
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'enviados_page');

        return view('mensajes.index', compact('usuario', 'recibidos', 'enviados'));
    }

    public function create(Request $request)
    {
        $usuario = Auth::user();
        $destinatarioId = $request->query('destinatario_id');

        if ($usuario->role === 'coordinador') {

            $destinatarios = User::with(['alumno', 'tutor'])->where('id', '!=', $usuario->id)
                ->orderBy('name')
                ->get();

        } elseif ($usuario->role === 'alumno') {

            $coordinadores = User::with(['alumno', 'tutor'])->where('role', User::ROLE_COORDINADOR)->get();

            $tutorIds = Practica::where('alumno_id', $usuario->alumno_id)
                ->whereNotNull('tutor_id')
                ->pluck('tutor_id')
                ->unique()
                ->toArray();

            $tutores = empty($tutorIds)
                ? collect()
                : User::with(['alumno', 'tutor'])->whereIn('tutor_id', $tutorIds)->get();

            $destinatarios = $coordinadores->merge($tutores)
                ->where('id', '!=', $usuario->id)
                ->unique('id')
                ->values();

        } elseif ($usuario->role === 'tutor') {

            $coordinadores = User::with(['alumno', 'tutor'])->where('role', User::ROLE_COORDINADOR)->get();

            $alumnoIds = Practica::where('tutor_id', $usuario->tutor_id)
                ->pluck('alumno_id')
                ->unique()
                ->toArray();

            $alumnos = empty($alumnoIds)
                ? collect()
                : User::with(['alumno', 'tutor'])->whereIn('alumno_id', $alumnoIds)->get();

            $destinatarios = $coordinadores->merge($alumnos)
                ->where('id', '!=', $usuario->id)
                ->unique('id')
                ->values();

        } else {
            $destinatarios = User::with(['alumno', 'tutor'])->where('role', User::ROLE_COORDINADOR)
                ->where('id', '!=', $usuario->id)
                ->orderBy('name')
                ->get();
        }

        return view('mensajes.create', compact('usuario', 'destinatarios', 'destinatarioId'));
    }

    public function store(Request $request)
    {
        $usuario = Auth::user();

        $validated = $request->validate([
            'destinatario_id' => ['required', 'exists:users,id', 'not_in:' . $usuario->id],
            'asunto'          => ['nullable', 'string', 'max:255'],
            'cuerpo'          => ['required', 'string'],
        ]);

        $destinatario = User::findOrFail($validated['destinatario_id']);

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

    public function show(Mensaje $mensaje)
    {
        $usuario = Auth::user();

        if ($mensaje->remitente_id !== $usuario->id && $mensaje->destinatario_id !== $usuario->id) {
            abort(403);
        }

        if ($mensaje->destinatario_id === $usuario->id && is_null($mensaje->leido_en)) {
            $mensaje->update(['leido_en' => now()]);
        }

        $mensaje->load(['remitente.alumno', 'remitente.tutor', 'destinatario.alumno', 'destinatario.tutor', 'practica.alumno', 'practica.empresa', 'practica.tutor']);

        return view('mensajes.show', compact('usuario', 'mensaje'));
    }
}
