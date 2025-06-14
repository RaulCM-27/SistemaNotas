<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignaturaProfesor extends Model
{
    protected $table = 'asignatura_profesor';

    public $timestamps = false;
    
    protected $fillable = [
        'profesor_id',
        'id_asignatura',
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
}
