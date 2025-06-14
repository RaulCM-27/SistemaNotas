<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsignaturaProfesor;
use App\Models\Profesor;
use Illuminate\Http\Request;

class AsignaturaProfesorController extends Controller
{
    public function index()
    {
        $profesores = Profesor::all();
        $asignaturas = Asignatura::all();
        $asignaciones = AsignaturaProfesor::with(['profesor', 'asignatura'])->get();

        return view('asignaciones.index', compact('profesores', 'asignaturas', 'asignaciones'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,profesor_id',
            'id_asignatura' => 'required|exists:asignaturas,id_asignatura',
        ]);

        // Evitar duplicados
        $existe = \App\Models\AsignaturaProfesor::where([
            ['profesor_id', $request->profesor_id],
            ['id_asignatura', $request->id_asignatura],
        ])->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Ya existe esta asignación.');
        }

        \App\Models\AsignaturaProfesor::create([
            'profesor_id' => $request->profesor_id,
            'id_asignatura' => $request->id_asignatura,
        ]);

        return redirect()->back()->with('success', 'Asignación registrada correctamente.');
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
        $request->validate([
            'profesor_id' => 'required|exists:profesores,profesor_id',
            'id_asignatura' => 'required|exists:asignaturas,id_asignatura',
        ]);

        $asignacion = AsignaturaProfesor::findOrFail($id);

        // Verificamos si ya existe otra asignación igual (excepto esta misma)
        $existe = AsignaturaProfesor::where('id', '!=', $id)
            ->where('profesor_id', $request->profesor_id)
            ->where('id_asignatura', $request->id_asignatura)
            ->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Ya existe otra asignación con esos datos.');
        }

        // Actualizamos la asignación
        $asignacion->update([
            'profesor_id' => $request->profesor_id,
            'id_asignatura' => $request->id_asignatura,
        ]);

        return redirect()->back()->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $asignacion = AsignaturaProfesor::findOrFail($id);
        $asignacion->delete();

        return redirect()->back()->with('success', 'Asignación eliminada correctamente.');
    }
}
