<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsignaturaProfesor;
use App\Models\Grado;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{

    public function index()
    {
        // Carga los horarios con las relaciones
        $horarios = Horario::with(['grado', 'asignacion.profesor', 'asignacion.asignatura'])->get();
        $grados = Grado::all();
        $asignaturas = Asignatura::all(); 

        $asignaciones = \App\Models\AsignaturaProfesor::with(['profesor', 'asignatura'])->get();

        return view('horarios.index', compact('horarios', 'grados', 'asignaturas', 'asignaciones'));
    }

    public function create()
    {
        // Traer grados y asignaciones para el formulario
        $grados = Grado::all();
        $asignaciones = AsignaturaProfesor::with(['profesor', 'asignatura'])->get();

        return view('horarios.create', compact('grados', 'asignaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_grado' => 'required|integer',
            'dia' => 'required|string',
            'id_asignacion' => 'required|integer',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $grado = $request->id_grado;
        $dia = $request->dia;
        $asignacion = $request->id_asignacion;
        $hora_inicio = $request->hora_inicio;
        $hora_fin = $request->hora_fin;

        // Obtener la asignación para identificar al profesor
        $asig = AsignaturaProfesor::find($asignacion);
        $profesor_id = $asig?->profesor_id;

        // Verificar cruce en el mismo grado
        $cruceGrado = Horario::where('id_grado', $grado)
            ->where('dia', $dia)
            ->where(function ($query) use ($hora_inicio, $hora_fin) {
                $query->whereBetween('hora_inicio', [$hora_inicio, $hora_fin])
                    ->orWhereBetween('hora_fin', [$hora_inicio, $hora_fin])
                    ->orWhere(function ($q) use ($hora_inicio, $hora_fin) {
                        $q->where('hora_inicio', '<=', $hora_inicio)
                            ->where('hora_fin', '>=', $hora_fin);
                    });
            })
            ->exists();

        if ($cruceGrado) {
            return redirect()->back()
                ->withErrors(['Este horario se cruza con otra asignatura del mismo grado.'])
                ->withInput();
        }

        // Verificar si el profesor ya tiene otra clase al mismo tiempo
        $cruceProfesor = Horario::whereHas('asignacion', function ($q) use ($profesor_id) {
            $q->where('profesor_id', $profesor_id);
        })
            ->where('dia', $dia)
            ->where(function ($query) use ($hora_inicio, $hora_fin) {
                $query->whereBetween('hora_inicio', [$hora_inicio, $hora_fin])
                    ->orWhereBetween('hora_fin', [$hora_inicio, $hora_fin])
                    ->orWhere(function ($q) use ($hora_inicio, $hora_fin) {
                        $q->where('hora_inicio', '<=', $hora_inicio)
                            ->where('hora_fin', '>=', $hora_fin);
                    });
            })
            ->exists();

        if ($cruceProfesor) {
            return redirect()->back()
                ->withErrors(['El profesor ya tiene una clase asignada en este horario.'])
                ->withInput();
        }

        // Guardar si no hay cruces
        Horario::create([
            'id_grado' => $grado,
            'dia' => $dia,
            'id_asignacion' => $asignacion,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
        ]);

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente');
    }
}
