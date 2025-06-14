<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios'; // Especificar nombre de la tabla si no sigue convención

    protected $primaryKey = 'id'; // Laravel usa "id" por defecto, si usas otro nombre, cambia aquí

    public $timestamps = false; // Si no usas created_at ni updated_at

    protected $fillable = [
        'dia',
        'hora_inicio',
        'hora_fin',
        'id_grado',
        'id_asignacion'
    ];

    // 🔗 Relación con Grado
    public function grado()
    {
        return $this->belongsTo(Grado::class, 'id_grado', 'id_grado');
    }

    // 🔗 Relación con AsignaturaProfesor
    public function asignacion()
    {
        return $this->belongsTo(AsignaturaProfesor::class, 'id_asignacion', 'id');
    }
}
