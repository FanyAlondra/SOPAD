<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        $usuarios = DB::table('usuario')->get();
        return view('cpanel.usuarios.indexusuarios', ['data' => $usuarios]);
    }

    // Mostrar formulario de creación
    public function create()
    {
        $instituciones = DB::table('institucion')->get();
        return view('cpanel.usuarios.createusuarios', compact('instituciones'));
    }

    // Guardar usuario
    public function store(Request $request)
    {
        DB::table('usuario')->insert([
            'nombre' => $request->nombre,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'correo' => $request->correo,
            'contrasena' => bcrypt($request->contrasena), // 🔒 importante
            'rol' => $request->rol,
            'id_institucion' => $request->id_institucion
        ]);

       return redirect()->route('usuarios.index');
    }

    // Editar usuario
    public function edit($id_usuario)
{
    $fila = DB::table('usuario')
        ->where('id_usuario', $id_usuario)
        ->first();

    $instituciones = DB::table('institucion')->get();

    return view('cpanel.usuarios.editusuarios', [
        'fila' => $fila,
        'instituciones' => $instituciones
    ]);
}

    // Actualizar usuario
    public function update(Request $request, $id_usuario)
    {
        $data = [
            'nombre' => $request->nombre,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'correo' => $request->correo,
            'rol' => $request->rol,
            'id_institucion' => $request->id_institucion
        ];

        // Solo actualiza contraseña si se envía
        if ($request->contrasena) {
            $data['contrasena'] = bcrypt($request->contrasena);
        }

        DB::table('usuario')
            ->where('id_usuario', $id_usuario)
            ->update($data);

        return redirect()->route('usuarios.index');
    }

    // Eliminar usuario
    public function destroy($id_usuario)
    {
        DB::table('usuario')->where('id_usuario', $id_usuario)->delete();
        return redirect()->route('usuarios.index');
    }
}