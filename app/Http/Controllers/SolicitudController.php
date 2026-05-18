<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudCorreccion; // Asegúrate de que el modelo exista
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SolicitudController extends Controller
{
    public function index()
    {
        // Cambiado de id_usuario a estudiante_id según tu SQL
        $solicitudes = SolicitudCorreccion::where('estudiante_id', Auth::id())->get();

        return view('dashboard_estudiante', compact('solicitudes'));
    }
    public function crearSolicitud()
{
    //  CONSEGUIR LA FECHA 
    //  CAPTURAR LA FECHA REAL
    $fechaHoy = now()->toDateString(); 

    //  BUSCADOR EN TIEMPO REAL: 
    // Busca la evaluación que tenga estado = 1 Y que  esté dentro de su rango de fechas
    $periodoActivo = DB::table('periodos_correccion')
        ->where('estado', 1)
        ->where('fecha_inicio', '<=', $fechaHoy)
        ->where('fecha_fin', '>=', $fechaHoy)
        ->first(); // Trae la fila completa como un objeto de tipo stdClass

    // 3. RESTRICCIÓN: Si hoy ninguna evaluación con estado 1 cumple con las fechas, REBOTA
    if (!$periodoActivo) {
        return redirect('/estudiante/dashboard')
            ->with('error', 'Por el momento el periodo de recepción de solicitudes para la corrección de notas se encuentra cerrado.');
    }
    //  Buscamos la carrera y facultad real del estudiante logueado (Auth::id())
    $datosEstudiante = DB::table('usuarios')
        ->join('carreras', 'usuarios.carrera_id', '=', 'carreras.id')
        ->join('facultades', 'carreras.facultad_id', '=', 'facultades.id')
        ->where('usuarios.id', Auth::id())
        ->select(
            'carreras.nombre as carrera_nombre',
            'facultades.nombre as facultad_nombre'
        )
        ->first();

    //  Consulta de Materias: Traemos el docente, la sección y la modalidad en un solo viaje
    $materias = DB::table('asignaciones_estudiante')
        ->join('materias', 'asignaciones_estudiante.materia_id', '=', 'materias.id')
        ->join('asignaciones_docente', function($join) {
            $join->on('asignaciones_estudiante.materia_id', '=', 'asignaciones_docente.materia_id')
                ->on('asignaciones_estudiante.seccion', '=', 'asignaciones_docente.seccion');
        })
        ->join('usuarios as docentes', 'asignaciones_docente.docente_id', '=', 'docentes.id')
        ->where('asignaciones_estudiante.estudiante_id', Auth::id())
        ->select(
            'materias.id as materia_id',
            'materias.nombre as materia_nombre',
            'asignaciones_estudiante.seccion as estudiante_seccion',
            'asignaciones_estudiante.modalidad as estudiante_modalidad', // 'presencial' o 'virtual'
            'docentes.id as docente_id',
            'docentes.nombre as docente_nombre'
        )
        ->get();


    //  Enviamos todo ordenadito a la vista
    return view('nueva_solicitud', compact('datosEstudiante', 'materias', 'periodoActivo'));
}
public function guardarSolicitud(Request $request)
{
    // . VALIDACIÓN
    $request->validate([
        'materia_id'  => 'required|integer',
        'docente_id'  => 'required|integer',
        'seccion'     => 'required|string',
        'nota_actual' => 'required|numeric|min:0|max:9.9',
        'periodo_id'  => 'required|integer',
        'motivo'      => 'required|string|min:10',
    ]);

    // . BUSCAR PERIODO — con guard para evitar crash si no existe
    $periodo = DB::table('periodos_correccion')
        ->where('id', $request->periodo_id)
        ->first();

    if (!$periodo) {
        return redirect('/estudiante/nueva-solicitud')
            ->with('error', 'El periodo seleccionado no es válido.');
    }

    // . BUSCAR CICLO — con guard
    $cicloData = DB::table('ciclos_academicos')
        ->where('id', $periodo->ciclo_id)
        ->first();

    if (!$cicloData) {
        return redirect('/estudiante/nueva-solicitud')
            ->with('error', 'No se encontró el ciclo académico asociado.');
    }

    // . INSERT — tabla y estado corregidos
    DB::table('solicitudes_correccion')->insert([
        'estudiante_id'   => Auth::id(),
        'materia_id'      => $request->materia_id,
        'docente_id'      => $request->docente_id,
        'seccion'         => $request->seccion,
        'nota_actual'     => $request->nota_actual,
        'motivo'          => $request->motivo,
        'evaluacion'      => $periodo->evaluacion,
        'ciclo_id'        => $periodo->ciclo_id,
        'ciclo'           => $cicloData->nombre,
        'estado'          => 'pendiente_docente', //  Valor real del ENUM
        'fecha_solicitud' => now(),
    ]);

    // . REDIRECCIÓN
    return redirect('/estudiante/dashboard')
        ->with('success', '¡Tu solicitud ha sido enviada al docente con éxito!');
}
}