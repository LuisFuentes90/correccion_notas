<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCorreccion extends Model
{
    protected $table = 'solicitudes_correccion';

    // Tu DB no usa created_at/updated_at, así que los desactivamos
    public $timestamps = false;

    protected $fillable = [
        'estudiante_id', // Nombre exacto de tu SQL
        'materia_id',
        'seccion',
        'ciclo_id',
        'ciclo',
        'docente_id',
        'evaluacion',
        'nota_actual',
        'motivo',
        'estado',
        'fecha_solicitud'
    ];

    // Dentro de la clase SolicitudCorreccion
    public function materiaRelacion()
    {
        // Relacionamos materia_id de esta tabla con el id de la tabla materias
        return $this->belongsTo(Materia::class, 'materia_id', 'id');
    }
}