<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSession
{
public function handle(Request $request, Closure $next)
{
    // 🔓 Permitir login y 2FA sin sesión
    if ($request->is('login') || $request->is('2fa')) {
        return $next($request);
    }

    // 🔒 Si no hay usuario autenticado → regresar al login
    if (!session()->has('usuario')) {
        return redirect('/login');
    }

    return $next($request);
}
}