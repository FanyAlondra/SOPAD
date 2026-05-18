<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    // LISTAR (sin mostrar campos ocultos)
    public function index()
    {
        $proyectos = DB::table('proyecto')
            ->select('id_proyecto', 'nom_proyecto', 'descripcion', 'fecha')
            ->where('estado', '1') // solo activos
            ->get();

        return view('cpanel.proyecto.indexproyecto', ['data' => $proyectos]);
    }

    // FORMULARIO CREAR
   // CREATE
public function create()
{
    $usuarios = DB::table('usuario')->get();
    return view('cpanel.proyecto.form', compact('usuarios'));
}

// EDIT
// EDIT (ÚNICO)
public function edit($id_proyecto)
{
    $fila = DB::table('proyecto')->where('id_proyecto', $id_proyecto)->first();
    $usuarios = DB::table('usuario')->get();

    return view('cpanel.proyecto.form', compact('fila','usuarios'));
}

    // GUARDAR
    public function store(Request $request)
    {
        DB::table('proyecto')->insert([
            'nom_proyecto'        => $request->nom_proyecto,
            'descripcion'         => $request->descripcion,
            'fecha'               => $request->fecha,
            'id_usuario'          => $request->id_usuario,

            // 👇 CAMPOS OCULTOS
            'estado'              => '1',
            'usuario_creacion'    => 'admin', // puedes cambiarlo por auth()->user()->name
            'fecha_creacion'      => now()
        ]);

        return redirect()->route('proyecto.index');
    }

   

    // ACTUALIZAR
    public function update(Request $request, $id_proyecto)
    {
        DB::table('proyecto')->where('id_proyecto', $id_proyecto)->update([
            'nom_proyecto'         => $request->nom_proyecto,
            'descripcion'          => $request->descripcion,
            'fecha'                => $request->fecha,
            'id_usuario'           => $request->id_usuario,

            // 👇 CAMPOS OCULTOS
            'usuario_modificacion' => 'admin', // o auth()->user()->name
            'fecha_modificacion'   => now()
        ]);

        return redirect()->route('proyecto.index');
    }

    // ELIMINAR (BORRADO LÓGICO)
    public function destroy($id_proyecto)
    {
        DB::table('proyecto')->where('id_proyecto', $id_proyecto)->update([
            'estado' => '0'
        ]);

        return redirect()->route('proyecto.index');
    }
}