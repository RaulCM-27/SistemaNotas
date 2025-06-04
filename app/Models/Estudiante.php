<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    protected $primaryKey = 'estudiante_id';

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'estudiante_id',
        'nombre_estudiante',
        'edad',
        'direccion',
        'telefono',
        'estado'
    ];
}
