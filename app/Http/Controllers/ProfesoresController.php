<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesoresController extends Controller
{
    public function index()
    {
        $profesores = Profesor::all();
        return view('profesores.index', compact('profesores'));
    }

    public function create()
    {
        return view('profesores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|integer|unique:profesores,profesor_id',
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string|max:100',
            'cedula' => 'required|string|max:20',
            'clave' => 'required|string|max:255',
            'telefono' => 'required|digits_between:7,20',
            'correo' => 'required|email|max:100',
            'nivel_est' => 'required|string|max:100',
            'estado' => 'required|in:0,1'
        ]);

        Profesor::create($request->all());

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor registrado correctamente.');
    }

    public function show($id)
    {
        $profesor = Profesor::findOrFail($id);
        return view('profesores.show', compact('profesor'));
    }

    public function edit($id)
    {
        $profesor = Profesor::findOrFail($id);
        return view('profesores.edit', compact('profesor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string|max:100',
            'cedula' => 'required|string|max:20',
            'clave' => 'required|string|max:255',
            'telefono' => 'required|digits_between:7,20',
            'correo' => 'required|email|max:100',
            'nivel_est' => 'required|string|max:100',
            'estado' => 'required|in:0,1'
        ]);

        $profesor = Profesor::findOrFail($id);
        $profesor->update($request->all());

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor actualizado correctamente.');
    }

    public function destroy($id)
    {
        $profesor = Profesor::findOrFail($id);
        $profesor->delete();

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor eliminado correctamente.');
    }
}
