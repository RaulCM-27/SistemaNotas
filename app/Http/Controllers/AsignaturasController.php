<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AsignaturasController extends Controller
{
    //Mostrar lista de asignaturas
    public function index()
    {
        $asignaturas = Asignatura::all();
        return view('asignaturas.index', compact('asignaturas'));
    }

    //Mostrar formulario para mostrar asignatura
    public function create()
    {
        return view('asignaturas.create');
    }

    //Guardar asignatura en la base de datos
    public function store(Request $request)
    {
        // Mensajes personalizados
        $messages = [
            'id_asignatura.unique' => '⚠️ El código de asignatura ya existe.',
            'id_asignatura.required' => 'El código de la asignatura es obligatorio.',
            'nombre_asignatura.required' => 'El nombre de la asignatura es obligatorio.',
            'horas_semanales.required' => 'Debes indicar cuántas horas semanales tiene.',
        ];

        // Validar los datos que vienen del formulario
        $request->validate([
            'id_asignatura' => 'required|string|unique:asignaturas,id_asignatura',
            'nombre_asignatura' => 'required|string|max:100',
            'horas_semanales' => 'required|integer|min:1',
        ], $messages); // 👈 aquí usas los mensajes personalizados

        // Crear la nueva asignatura
        Asignatura::create($request->all());

        // Redireccionar con mensaje de éxito
        return redirect()->route('asignaturas.index')->with('success', 'Asignatura registrada correctamente.');
    }

    //Mostrar los detalles de una asignatura
    public function show(string $id)
    {
        $asignatura = Asignatura::findOrFail($id);
        return view('asignatura.show', compact('asignatura'));
    }

    //Mostrar formulario para editar una asignatura
    public function edit(string $id)
    {
        $asignatura = Asignatura::findOrFail($id);
        return view('asignatura.edit', compact('asignatura'));
    }

    //Actualizar un estudiante existente
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre_asignatura' => 'required|string|max:100',
            'horas_semanales' => 'required|integer|min:1',
        ]);

        $asignatura = Asignatura::findOrFail($id);

        $asignatura->update($request->all());

        return redirect()->route('asignaturas.index')->with('success', 'Asignatura actualizada correctamente.');
    }

    //Eliminar un estudiante
    public function destroy(string $id)
    {
        try {
            $asignatura = Asignatura::findOrFail($id);
            $asignatura->delete();

            return redirect()
                ->route('asignaturas.index')
                ->with('success', 'Asignatura eliminada correctamente.');
        } catch (QueryException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1451) {
                return redirect()
                    ->route('asignaturas.index')
                    ->with('error', 'No se puede eliminar esta asignatura porque está siendo utilizada en asignaciones o horarios.');
            }
            throw $e;
        }
    }
}
