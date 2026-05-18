<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class VentasAnualesController extends Controller
{
    public function index()
    {
        $ventas = DB::table('ventas_anuales')->get();
        return view('cpanel.ventasanuales.indexventasanuales', ['data' => $ventas]);
    }

   public function create()
{
    $materias = DB::table('materia_prima')->where('estado',1)->get();
    return view('cpanel.ventasanuales.createventasanuales', compact('materias'));
}

   public function store(Request $request)
{
    $mensual = $request->num_articulo * $request->costo_unitario;
    $anual = $mensual * 12;

    DB::table('ventas_anuales')->insert([
        'id_mp' => $request->id_mp,
        'num_articulo' => $request->num_articulo,
        'costo_unitario' => $request->costo_unitario,
        'mensual' => $mensual,
        'anual' => $anual,
        'anno' => $request->anno,

        // 🔥 ESTO ES LO QUE TE FALTA GUARDAR BIEN
        'estado' => 1,
        'usuario_creacion' => 'admin',
        'fecha_creacion' => now()
    ]);

    return redirect()->route('ventas.index');
}
    


   
    public function edit($id_venta)
    {
        $fila = DB::table('ventas_anuales')->where('id_venta', $id_venta)->first();
        $materias = DB::table('materia_prima')->get();
        return view('cpanel.ventasanuales.editventasanuales', [
            'fila' => $fila,
            'materias' => $materias
        ]);
    }

    public function update(Request $request, $id_venta)
{
    $mensual = $request->num_articulo * $request->costo_unitario;
    $anual = $mensual * 12;

    DB::table('ventas_anuales')
        ->where('id_venta', $id_venta)
        ->update([
            
            'id_mp' => $request->id_mp,
            'num_articulo' => $request->num_articulo,
            'costo_unitario' => $request->costo_unitario,
            'mensual' => $mensual,
            'anual' => $anual,
            'anno' => Carbon::now()->year 
            
        ]);

    return redirect()->route('ventas.index');
}

    public function destroy($id_venta)
    {
        DB::table('ventas_anuales')->where('id_venta', $id_venta)->delete();
        return redirect()->route('ventas.index');
    }
}