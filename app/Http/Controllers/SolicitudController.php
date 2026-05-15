<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudCorreccion; // Asegúrate de que el modelo exista
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    public function index()
    {
        // Cambiado de id_usuario a estudiante_id según tu SQL
        $solicitudes = SolicitudCorreccion::where('estudiante_id', Auth::id())->get();

        return view('dashboard_estudiante', compact('solicitudes'));
    }
}