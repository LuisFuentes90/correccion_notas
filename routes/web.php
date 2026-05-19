<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\DocenteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prueba-db', function () {
    try {
        $usuarios = DB::table('usuarios')->get();
        return $usuarios;
    } catch (\Exception $e) {
        return "Error al conectar: " . $e->getMessage();
    }
});

// Ruta para mostrar el formulario
Route::get('/login', function () {
    return view('login');
})->name('login');

// Ruta para procesar los datos cuando des clic al botón
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/encriptar-mi-clave', function () {
    // Buscamos a tu usuario por correo (ajusta el correo si es otro)
    $user = User::where('correo', 'luis.m@utec.com')->first();
    
    if ($user) {
        $user->password = Hash::make('1234'); // Aquí la encriptamos
        $user->save();
        return "Contraseña actualizada para Luis. ¡Ya puedes intentar el login!";
    }
    
    return "Usuario no encontrado.";
});

Route::get('/estudiante/dashboard', [SolicitudController::class, 'index'])->middleware('auth');
// Ruta para mostrar el formulario de nueva solicitud
Route::get('/estudiante/nueva-solicitud', [SolicitudController::class, 'crearSolicitud'])->middleware('auth');
// Ruta para guardar la solicitud (esta es la que se llama al enviar el formulario)
Route::post('/estudiante/guardar-solicitud', [SolicitudController::class, 'guardarSolicitud'])->middleware('auth');
//  Ruta para ver el detalle de una solicitud específica
Route::get('/estudiante/solicitud/{id}', [SolicitudController::class, 'verDetalle'])->middleware('auth');
// Ruta para cancelar una solicitud (cambia su estado a cancelado)
Route::get('/docente/dashboard', [DocenteController::class, 'index'])->middleware('auth');
// Ruta para ver el detalle de una solicitud específica para el docente
Route::get('/docente/solicitud/{id}', [DocenteController::class, 'verDetalle'])->middleware('auth');
// Ruta para procesar la decisión del docente (aprobar/rechazar)
Route::post('/docente/solicitud/{id}/decision', [DocenteController::class, 'procesarDecision'])->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');