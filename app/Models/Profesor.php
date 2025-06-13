<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';

    protected $primaryKey = 'profesor_id';

    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'profesor_id',
        'nombre',
        'telefono',
        'correo',
    ];

    // Relación con la tabla intermedia
    public function asignaturasGrados()
    {
        return $this->hasMany(AsignaturaProfesorGrado::class, 'profesor_id', 'profesor_id');
    }
}
