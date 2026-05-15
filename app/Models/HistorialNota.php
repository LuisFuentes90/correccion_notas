<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialNota extends Model
{
    protected $table = 'historial_notas';

    protected $fillable = [
        'solicitud_id',
        'nota_anterior',
        'nota_nueva',
        'usuario_id'
    ];

    // Relación inversa: Un historial pertenece a una solicitud
    public function solicitud()
    {
        return $this->belongsTo(SolicitudCorreccion::class, 'solicitud_id');
    }
}
