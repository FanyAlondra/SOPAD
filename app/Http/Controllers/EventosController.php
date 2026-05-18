<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventosController extends Controller
{
    public function index()
    {
        $eventos = DB::table('eventos')->get();
        return view('cpanel.eventos.indexeventos', ['data' => $eventos]);
    }
     public function create()
    {
        return view('cpanel.eventos.createeventos');
    }

    public function store(Request $request)
    {
        DB::table('eventos')->insert([
            'nombre_evento'       => $request->nombre_evento,
            'etapa'   => $request->etapa,
            'periodo'   => $request->periodo,
            'convocatoria'       => $request->convocatoria,
            'descripcion_evento'   => $request->descripcion_evento
            
        ]);

       
        return redirect()->route('eventos.index');
    }

    public function destroy($id_evento)
    {
        DB::table('eventos')->where('id_evento', $id_evento)->delete();

       
        return redirect()->route('eventos.index');
    }
    public function edit($id_evento)
    {
        $fila = DB::table('eventos')->where('id_evento', $id_evento)->first();
        return view('cpanel.eventos.editeventos', ['fila' => $fila]);
    }

    public function update(Request $request, $id_evento)
    {
        DB::table('eventos')->where('id_evento', $id_evento)->update([
            'nombre_evento'       => $request->nombre_evento,
            'etapa'   => $request->etapa,
            'periodo'   => $request->periodo,
            'convocatoria'       => $request->convocatoria,
            'descripcion_evento'   => $request->descripcion_evento
        ]);

        
         return redirect()->route('eventos.index');
    }
}
