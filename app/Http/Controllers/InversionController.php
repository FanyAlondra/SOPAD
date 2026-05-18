<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InversionController extends Controller
{
    public function index($id_proyecto)
    {
        session(['id_proyecto_actual' => $id_proyecto]);

        $proyecto = DB::table('proyecto')
            ->where('id_proyecto', $id_proyecto)
            ->first();

        $inversion = DB::table('inversion')
            ->where('id_proyecto', $id_proyecto)
            ->first();

        return view('cpanel.inversion.index', compact(
            'proyecto',
            'inversion',
            'id_proyecto'
        ));
    }

    public function create($id_proyecto)
    {
        return view('cpanel.inversion.form', compact('id_proyecto'));
    }

    public function store(Request $request, $id_proyecto)
    {
        DB::table('inversion')->insert([
            'id_proyecto' => $id_proyecto,
            'aportacion_especie' => $request->aportacion_especie,
            'aportacion_efectivo' => $request->aportacion_efectivo,
            'tasa_descuento' => $request->tasa_descuento,
            'depreciacion' => $request->depreciacion,
            'años_proyeccion' => $request->años_proyeccion,
        ]);

        return redirect("/admon/proyecto/$id_proyecto/inversion")
            ->with('success', 'Inversión registrada correctamente');
    }

    public function edit($id_proyecto, $id_inversion)
    {
        $fila = DB::table('inversion')
            ->where('id_inversion', $id_inversion)
            ->where('id_proyecto', $id_proyecto)
            ->first();

        return view('cpanel.inversion.form', compact('fila', 'id_proyecto'));
    }

    public function update(Request $request, $id_proyecto, $id_inversion)
    {
        DB::table('inversion')
            ->where('id_inversion', $id_inversion)
            ->where('id_proyecto', $id_proyecto)
            ->update([
                'aportacion_especie' => $request->aportacion_especie,
                'aportacion_efectivo' => $request->aportacion_efectivo,
                'tasa_descuento' => $request->tasa_descuento,
                'depreciacion' => $request->depreciacion,
                'años_proyeccion' => $request->años_proyeccion,
            ]);

        return redirect("/admon/proyecto/$id_proyecto/inversion")
            ->with('success', 'Inversión actualizada correctamente');
    }

    public function destroy($id_proyecto, $id_inversion)
    {
        DB::table('inversion')
            ->where('id_inversion', $id_inversion)
            ->where('id_proyecto', $id_proyecto)
            ->delete();

        return redirect("/admon/proyecto/$id_proyecto/inversion")
            ->with('success', 'Inversión eliminada correctamente');
    }
}