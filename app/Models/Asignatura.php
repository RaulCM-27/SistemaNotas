<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = 'asignaturas';

    protected $primaryKey = 'id_asignatura';

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_asignatura',
        'nombre_asignatura',
        'horas_semanales',
    ];

    //Relacion con tabla intermedia
    public function profesores()
    {
        return $this->hasMany(AsignaturaProfesor::class, 'id_asignatura', 'id_asignatura');
    }
}
