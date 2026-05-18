<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaborDirectaController extends Controller
{

    public function index()
    {
        $datos = DB::table('labor_directa')->get();

        return view('cpanel.labordirecta.indexlabordirecta', compact('datos'));
    }


    public function create()
    {
        return view('cpanel.labordirecta.form');
    }


    public function store(Request $request)
    {

        $total = $request->operario + $request->disenador;

        DB::table('labor_directa')->insert([

            'operario' => $request->operario,
            'disenador' => $request->disenador,
            'costo_directo' => $request->costo_directo,
            'total' => $total

        ]);

        return redirect()->route('labordirecta.index');
    }


    public function edit($id)
    {

        $fila = DB::table('labor_directa')
            ->where('id_labor', $id)
            ->first();

        return view('cpanel.labordirecta.form', compact('fila'));
    }


    public function update(Request $request, $id)
    {

        $total = $request->operario + $request->disenador;

        DB::table('labor_directa')
            ->where('id_labor', $id)
            ->update([

                'operario' => $request->operario,
                'disenador' => $request->disenador,
                'costo_directo' => $request->costo_directo,
                'total' => $total

            ]);

        return redirect()->route('labordirecta.index');
    }


    public function destroy($id)
    {

        DB::table('labor_directa')
            ->where('id_labor', $id)
            ->delete();

        return redirect()->route('labordirecta.index');
    }

}