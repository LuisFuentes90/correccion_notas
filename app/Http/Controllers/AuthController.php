<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Esta función servirá para procesar el formulario de login
    public function login(Request $request)
    {
        // 1. Validamos los datos que vienen del formulario
        $credentials = $request->validate([
            'correo' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Intentamos iniciar sesión
        // Nota: Laravel por defecto busca 'email', así que le especificamos que use 'correo'
        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            // 3. Obtenemos el usuario para ver su rol y mandarlo a su panel
            $user = Auth::user();

            return match($user->rol) {
                'admin'       => redirect()->intended('/admin/dashboard'),
                'docente'     => redirect()->intended('/docente/dashboard'),
                'coordinador' => redirect()->intended('/coordinador/dashboard'),
                default       => redirect()->intended('/estudiante/dashboard'), // Estudiantes
            };
        }

        // 4. Si falla, lo mandamos de regreso con error
        return back()->withErrors([
            'correo' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    // Función para cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}