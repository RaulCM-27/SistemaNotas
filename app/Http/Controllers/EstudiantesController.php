<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
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
            'estudiante_id' => 'required|string|max:20|unique:estudiantes,estudiante_id',
            'nombre_estudiante' => 'required|string|max:100',
            'edad' => 'required|integer',
            'direccion' => 'nullable|string|max:100',
            'telefono' => 'nullable|numeric',
            'estado' => 'required|integer'
        ]);

        Estudiante::create($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante registrado correctamente.');
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
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado correctamente.');
    }
}
