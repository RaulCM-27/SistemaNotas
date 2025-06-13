<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsignaturaProfesorGrado;
use App\Models\Grado;
use App\Models\Profesor;
use Illuminate\Http\Request;

class AsignaturaProfesorGradoController extends Controller
{

    public function index()
    {
        $profesores = Profesor::all();
        $asignaturas = Asignatura::all();
        $grados = Grado::all();
        $asignaciones = AsignaturaProfesorGrado::with(['profesor', 'asignatura', 'grado'])->get();

        return view('asignaciones.index', compact('profesores', 'asignaturas', 'grados', 'asignaciones'));
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
            'id_grado' => 'required|exists:grados,id_grado',
        ]);

        // Evitar duplicados
        $existe = \App\Models\AsignaturaProfesorGrado::where([
            ['profesor_id', $request->profesor_id],
            ['id_asignatura', $request->id_asignatura],
            ['id_grado', $request->id_grado],
        ])->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Ya existe esta asignación.');
        }

        \App\Models\AsignaturaProfesorGrado::create([
            'profesor_id' => $request->profesor_id,
            'id_asignatura' => $request->id_asignatura,
            'id_grado' => $request->id_grado,
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
            'id_grado' => 'required|exists:grados,id_grado',
        ]);

        $asignacion = AsignaturaProfesorGrado::findOrFail($id);

        // Verificamos si ya existe otra asignación igual (excepto esta misma)
        $existe = AsignaturaProfesorGrado::where('id', '!=', $id)
            ->where('profesor_id', $request->profesor_id)
            ->where('id_asignatura', $request->id_asignatura)
            ->where('id_grado', $request->id_grado)
            ->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Ya existe otra asignación con esos datos.');
        }

        // Actualizamos la asignación
        $asignacion->update([
            'profesor_id' => $request->profesor_id,
            'id_asignatura' => $request->id_asignatura,
            'id_grado' => $request->id_grado,
        ]);

        return redirect()->back()->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $asignacion = AsignaturaProfesorGrado::findOrFail($id);
        $asignacion->delete();

        return redirect()->back()->with('success', 'Asignación eliminada correctamente.');
    }
}
