<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCorreccion extends Model
{
    // Le decimos a Laravel el nombre exacto de la tabla
    protected $table = 'solicitudes_correccion';

    // Estos son los campos que permitiremos llenar
    protected $fillable = [
        'estudiante_id', 
        'materia_id', 
        'ciclo_id', 
        'nota_anterior', 
        'nota_nueva', 
        'motivo', 
        'estado', // Aquí usaremos los nuevos: pendiente_docente, etc.
        'archivo_evidencia'
    ];

    // Relación con el historial de cambios (Punto 6 de tu amigo)
    public function historial()
    {
        return $this->hasMany(HistorialNota::class, 'solicitud_id');
    }
}
