<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    protected $table = 'grados';
    protected $primaryKey = 'id_grado';
    public $timestamps = false; 
    
    protected $fillable = ['id_grado', 'nivel_grado', 'letra_grado'];

    /**
     * Relación con matrículas
     * Un grado puede tener muchas matrículas
     */
    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'id_grado', 'id_grado');
    }

    /**
     * Obtener matrículas de un año específico
     */
    public function matriculasPorAño($año)
    {
        return $this->matriculas()->where('año_escolar', $año);
    }

    /**
     * Verificar si el grado está completo (40 estudiantes)
     */
    public function estaCompleto($año = null)
    {
        $año = $año ?? date('Y');
        return $this->matriculasPorAño($año)->count() >= 40;
    }

    /**
     * Obtener cupos disponibles
     */
    public function cuposDisponibles($año = null)
    {
        $año = $año ?? date('Y');
        $matriculados = $this->matriculasPorAño($año)->count();
        return max(0, 40 - $matriculados);
    }

    /**
     * Obtener el nombre completo del grado (nivel + letra)
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nivel_grado . $this->letra_grado;
    }

    /**
     * Scope para grados con cupos disponibles
     */
    public function scopeConCupos($query, $año = null)
    {
        $año = $año ?? date('Y');
        return $query->whereDoesntHave('matriculas', function($q) use ($año) {
            $q->where('año_escolar', $año);
        }, '>=', 40);
    }

    /**
     * Scope para ordenar por nivel y letra
     */
    public function scopeOrdenado($query)
    {
        return $query->orderBy('nivel_grado')->orderBy('letra_grado');
    }
}