<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;

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