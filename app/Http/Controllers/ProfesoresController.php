<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesoresController extends Controller
{
    // Mostrar todos los profesores
    public function index()
    {
        $profesores = Profesor::all();
        return view('profesores.index', compact('profesores'));
    }

    // Guardar nuevo profesor
    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|integer|unique:profesores,profesor_id',
            'nombre' => 'required|string|max:100',
            'telefono' => 'required|digits_between:7,20',
            'correo' => 'required|email|max:100',
        ], [
            // Mensajes personalizados
            'profesor_id.required' => '⛔ El campo ID del profesor es obligatorio.',
            'profesor_id.unique' => '⛔ El ID del profesor ya está registrado.',
        ]);

        Profesor::create($request->all());

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor registrado correctamente.');
    }


    // Mostrar un profesor (opcional)
    public function show($id)
    {
        $profesor = Profesor::findOrFail($id);
        return view('profesores.show', compact('profesor'));
    }

    // Editar profesor (opcional)
    public function edit($id)
    {
        $profesor = Profesor::findOrFail($id);
        return view('profesores.edit', compact('profesor'));
    }

    // Actualizar profesor
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'required|digits_between:7,20',
            'correo' => 'required|email|max:100',
        ]);

        $profesor = Profesor::findOrFail($id);
        $profesor->update($request->all());

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor actualizado correctamente.');
    }

    // Eliminar profesor
    public function destroy($id)
    {
        $profesor = Profesor::findOrFail($id);
        $profesor->delete();

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor eliminado correctamente.');
    }
}
