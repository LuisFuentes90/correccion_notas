<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarRol
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si no está logueado, al login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Si su rol no está en los roles permitidos, rebotar
        if (!in_array(Auth::user()->rol, $roles)) {
            return redirect('/login')
                ->with('error', 'No tienes permiso para acceder a esa sección.');
        }

        return $next($request);
    }
}