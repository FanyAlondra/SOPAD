<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\TwoFactorCodeMail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('cpanel.login.login');
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|regex:/@smartin\.tecnm\.mx$/',
            'contrasena' => 'required'
        ]);

        // Buscar usuario por correo
        $user = User::where('correo', $request->correo)->first();

        // Verificar contraseña
        if (!$user || !Hash::check($request->contrasena, $user->contrasena)) {
            return back()->withErrors([
                'correo' => 'Correo o contraseña incorrectos.'
            ]);
        }

        // Generar código 2FA
        $user->generateTwoFactorCode();

        // Enviar código al correo
       dd($user->two_factor_code);

        // Guardar sesión temporal
        session(['2fa_user_id' => $user->id_usuario]);

        return redirect()
            ->route('twofactor.index')
            ->with('codigo', 'Se envió un código a tu correo.');
    }

    public function twoFactorIndex()
    {
        return view('cpanel.login.twofactor');
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|numeric'
        ]);

        $userId = session('2fa_user_id');

        $user = User::where('id_usuario', $userId)->first();

        if (!$user || $user->two_factor_code != $request->two_factor_code) {
            return back()->withErrors([
                'two_factor_code' => 'Código incorrecto'
            ]);
        }

        $user->resetTwoFactorCode();

// Guardar usuario logueado
session(['usuario' => $user]);

if ($user->rol == 'admin') {
    return redirect()->route('admin.dashboard');
} elseif ($user->rol == 'profesor') {
    return redirect()->route('profesor.dashboard');
} else {
    return redirect()->route('estudiante.dashboard');
}
    }

    public function perfil()
    {
        $user = User::where(
            'id_usuario',
            session('usuario')->id_usuario
        )->first();

        return view('cpanel.perfil.index', compact('user'));
    }

    public function subirFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $user = User::where(
            'id_usuario',
            session('usuario')->id_usuario
        )->first();

        if ($request->hasFile('foto')) {
            $ruta = $request->file('foto')->store('usuarios', 'public');

            $user->foto = $ruta;
            $user->save();

            session(['usuario' => $user]);
        }

        return back();
    }

    public function eliminarFoto()
    {
        $user = User::where(
            'id_usuario',
            session('usuario')->id_usuario
        )->first();

        $user->foto = null;
        $user->save();

        session(['usuario' => $user]);

        return back();
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'actual' => 'required',
            'nueva' => 'required|min:4',
            'confirmar' => 'required|same:nueva'
        ]);

        $user = User::where(
            'id_usuario',
            session('usuario')->id_usuario
        )->first();

        if (!Hash::check($request->actual, $user->contrasena)) {
            return back()->withErrors([
                'actual' => 'Contraseña actual incorrecta'
            ]);
        }

        $user->contrasena = bcrypt($request->nueva);
        $user->save();

        return back()->with(
            'success',
            'Contraseña actualizada correctamente'
        );
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}