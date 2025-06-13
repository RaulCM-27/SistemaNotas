<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    protected $table = 'grados';

    protected $primaryKey = 'id_grado';

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_grado',
        'nivel_grado',
        'letra_grado',
    ];

    //Relacion con tabla intermedia
    public function profesoresAsignaturas()
    {
        return $this->hasMany(AsignaturaProfesorGrado::class, 'id_grado', 'id_grado');
    }
}
