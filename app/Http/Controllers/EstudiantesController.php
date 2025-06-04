<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudiantesController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::all();
        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        return view('estudiantes.create'); // ahora carga el formulario
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|integer|unique:estudiantes,alumno_id',
            'nombre_estudiante' => 'required|string|max:100',
            'edad' => 'required|integer',
            'direccion' => 'required|string|max:100',
            'cedula' => 'required|string|max:20',
            'telefono' => 'required|digits_between:7,20',
            'correo' => 'required|email|max:100',
            'fecha_nac' => 'required|date',
            'fecha_registro' => 'required|date',
            'estado' => 'required|in:0,1',
        ]);

        Estudiante::create($request->all());

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante creado correctamente');
    }

    public function show($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_estudiante' => 'required|string|max:100',
            'edad' => 'required|integer',
            'direccion' => 'required|string|max:100',
            'cedula' => 'required|string|max:20',
            'telefono' => 'required|digits_between:7,20',
            'correo' => 'required|email|max:100',
            'fecha_nac' => 'required|date',
            'fecha_registro' => 'required|date',
            'estado' => 'required|in:0,1',
        ]);

        $estudiante = Estudiante::findOrFail($id);
        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente');
    }

    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado correctamente');
    }
}
