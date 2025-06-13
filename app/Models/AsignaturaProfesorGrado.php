<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignaturaProfesorGrado extends Model
{
    protected $table = 'asignatura_profesor_grado';

    public $timestamps = false;
    
    protected $fillable = [
        'profesor_id',
        'id_asignatura',
        'id_grado',
    ];

    // Relaciones
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'id_grado');
    }
}
