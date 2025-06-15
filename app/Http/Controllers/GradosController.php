<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GradosController extends Controller
{
    //Mostrar lista de grados
    public function index()
    {
        $grados = Grado::all();
        return view('grados.index', compact('grados'));
    }

    //Mostrar formulario para mostrar grado
    public function create()
    {
        return view('grados.create');
    }

    //Guardar grado en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'id_grado'     => 'required|string|unique:grados,id_grado',
            'nivel_grado'  => 'required|string|max:3',
            'letra_grado'  => 'required|string|max:1',
        ], [
            'id_grado.unique'   => '⛔ Ya existe un grado con este ID.',
        ]);

        Grado::create($request->all());

        return redirect()->route('grados.index')
            ->with('success', 'Grado creado correctamente.');
    }


    //Mostrar los detalles de la asignatura
    public function show(string $id)
    {
        $grado = Grado::findOrFail($id);
        return view('grados.show', compact('grado'));
    }

    //Mostrar formulario para editar un grado
    public function edit(string $id)
    {
        $grado = Grado::findOrFail($id);
        return view('grados.edit', compact('grado'));
    }

    //Actualizar un grado existente
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nivel_grado' => 'required|string|max:3',
            'letra_grado' => 'required|string|max:1',
        ]);

        $grado = Grado::findOrFail($id);
        $grado->update($request->all());

        return redirect()->route('grados.index')->with('success', 'Grado actualizado correctamente.');
    }

    //Eliminar un grado
    public function destroy(string $id)
    {
        try {
            $grado = Grado::findOrFail($id);
            $grado->delete();

            return redirect()
                ->route('grados.index')
                ->with('success', 'Grado eliminado correctamente.');
        } catch (QueryException $e) {
            // Código 1451: no se puede eliminar por restricción de FK
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1451) {
                return redirect()
                    ->route('grados.index')
                    ->with('error', 'No se puede eliminar este grado porque está siendo utilizado en horarios u otras relaciones.');
            }
            // Si es otro error, relanzarlo
            throw $e;
        }
    }
}
