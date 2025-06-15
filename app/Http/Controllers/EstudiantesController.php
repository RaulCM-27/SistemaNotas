<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EstudiantesController extends Controller
{
    // Mostrar lista de estudiantes
    public function index()
    {
        $estudiantes = Estudiante::all();
        return view('estudiantes.index', compact('estudiantes'));
    }

    // Mostrar formulario para crear un estudiante
    public function create()
    {
        return view('estudiantes.create');
    }

    // Guardar nuevo estudiante en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => [
                'required',
                'string',
                'max:20',
                'unique:estudiantes,estudiante_id'
            ],
            'nombre_estudiante' => 'required|string|max:100',
            'edad' => 'required|integer',
            'direccion' => 'nullable|string|max:100',
            'telefono' => 'nullable|numeric',
            'estado' => 'required|integer'
        ], [
            // Mensajes personalizados
            'estudiante_id.unique' => '⛔ El ID del estudiante ya está registrado. Por favor, use uno diferente.',
            'estudiante_id.required' => '⛔ El campo ID estudiante es obligatorio.',
            'nombre_estudiante.required' => '⛔ El nombre del estudiante es obligatorio.',
            'edad.required' => '⛔ La edad del estudiante es obligatoria.',
            'edad.integer' => '⛔ La edad debe ser un número entero.',
        ]);

        Estudiante::create($request->all());

        return redirect()->route('estudiantes.index')->with('success', ' Estudiante registrado correctamente.');
    }


    // Mostrar los detalles de un estudiante
    public function show(string $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        return view('estudiantes.show', compact('estudiante'));
    }

    // Mostrar formulario para editar un estudiante
    public function edit(string $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        return view('estudiantes.edit', compact('estudiante'));
    }

    // Actualizar un estudiante existente
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre_estudiante' => 'required|string|max:100',
            'edad' => 'required|integer',
            'direccion' => 'nullable|string|max:100',
            'telefono' => 'nullable|numeric',
            'estado' => 'required|integer'
        ]);

        $estudiante = Estudiante::findOrFail($id);
        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    // Eliminar un estudiante
    public function destroy(string $id)
    {
        try {
            $estudiante = Estudiante::findOrFail($id);
            $estudiante->delete();

            return redirect()
                ->route('estudiantes.index')
                ->with('success', 'Estudiante eliminado correctamente.');
        } catch (QueryException $e) {
            // 1451: Cannot delete or update a parent row: a foreign key constraint fails
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1451) {
                return redirect()
                    ->route('estudiantes.index')
                    ->with('error', 'No se puede eliminar este estudiante porque está siendo referenciado en otros registros.');
            }
            // Si es otra excepción, relanzamos
            throw $e;
        }
    }
}
