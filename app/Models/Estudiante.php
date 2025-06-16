<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    /**
     * La tabla asociada con el modelo.
     */
    protected $table = 'estudiantes';

    /**
     * La clave primaria de la tabla.
     */
    protected $primaryKey = 'estudiante_id';

    /**
     * Indica si la clave primaria es auto-incremental.
     */
    public $incrementing = false;

    /**
     * El tipo de datos de la clave primaria.
     */
    protected $keyType = 'string';

    /**
     * Indica si el modelo debe usar timestamps.
     */
    public $timestamps = false;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'estudiante_id',
        'nombre_estudiante',
        'edad',
        'direccion',
        'telefono',
        'estado',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'edad' => 'integer',
        'telefono' => 'integer',
        'estado' => 'integer',
    ];

    /**
     * Relación con matrículas
     * Un estudiante puede tener muchas matrículas
     */
    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'estudiante_id', 'estudiante_id');
    }

    /**
     * Obtener matrículas de un año específico
     */
    public function matriculasPorAño($año)
    {
        return $this->matriculas()->where('año_escolar', $año);
    }

    /**
     * Verificar si el estudiante está matriculado en un año específico
     */
    public function estaMatriculado($año = null)
    {
        $año = $año ?? date('Y');
        return $this->matriculasPorAño($año)->exists();
    }

    /**
     * Obtener la matrícula actual del estudiante
     */
    public function matriculaActual()
    {
        return $this->matriculas()
                    ->where('año_escolar', date('Y'))
                    ->with('grado')
                    ->first();
    }

    /**
     * Scope para estudiantes activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }

    /**
     * Scope para estudiantes inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('estado', 0);
    }

    /**
     * Scope para buscar por nombre o ID
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre_estudiante', 'LIKE', "%{$termino}%")
                    ->orWhere('estudiante_id', 'LIKE', "%{$termino}%");
    }

    /**
     * Scope para filtrar por edad
     */
    public function scopePorEdad($query, $edadMin, $edadMax = null)
    {
        $query->where('edad', '>=', $edadMin);
        
        if ($edadMax) {
            $query->where('edad', '<=', $edadMax);
        }
        
        return $query;
    }

    /**
     * Accessor para formatear el nombre
     */
    public function getNombreFormateadoAttribute()
    {
        return ucwords(strtolower($this->nombre_estudiante));
    }

    /**
     * Accessor para obtener el estado como texto
     */
    public function getEstadoTextoAttribute()
    {
        return $this->estado == 1 ? 'Activo' : 'Inactivo';
    }

    /**
     * Mutator para el nombre del estudiante
     */
    public function setNombreEstudianteAttribute($value)
    {
        $this->attributes['nombre_estudiante'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Mutator para la dirección
     */
    public function setDireccionAttribute($value)
    {
        $this->attributes['direccion'] = $value ? ucwords(strtolower(trim($value))) : null;
    }
}
