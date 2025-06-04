<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';
    protected $primaryKey = 'profesor_id';
    public $timestamps = false; // si no usas created_at y updated_at

    protected $fillable = [
        'profesor_id',
        'nombre',
        'direccion',
        'cedula',
        'clave',
        'telefono',
        'correo',
        'nivel_est',
        'estado'
    ];
}
