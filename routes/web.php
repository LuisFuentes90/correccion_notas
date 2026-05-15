<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

Route::get('/estudiante/dashboard', function () {
    return view('dashboard_estudiante');
})->middleware('auth');