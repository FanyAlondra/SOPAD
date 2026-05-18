<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MateriaPrimaExport;

class MateriaPrimaController extends Controller
{
    // =========================================
    // LISTAR
    // =========================================
    
    public function index($id_proyecto)
    {
        session(['id_proyecto_actual' => $id_proyecto]);
        $proyecto = DB::table('proyecto')
            ->where('id_proyecto', $id_proyecto)
            ->first();

        $materiaprima = DB::table('materia_prima')
            ->where('estado', 1)
            ->where('id_proyecto', $id_proyecto)
            ->orderBy('id_mp', 'desc')
            ->paginate(20);

        foreach ($materiaprima as $fila) {

            $resultado = $this->buscarLugar(
                $fila->nombre_articulo
            );

            $fila->lugar_compra =
                $resultado['lugar'];

            $fila->maps =
                'https://www.google.com/maps?q=' .
                $resultado['lat'] . ',' .
                $resultado['lon'];
        }

        return view(
            'cpanel.materiaprima.indexmateriaprima',
            [
                'data' => $materiaprima,
                'id_proyecto' => $id_proyecto,
                'proyecto' => $proyecto
            ]
        );
    }

    // =========================================
    // CREAR
    // =========================================
    public function create($id_proyecto)
    {
        return view(
            'cpanel.materiaprima.createmateriaprima',
            compact('id_proyecto')
        );
    }

    // =========================================
    // GUARDAR
    // =========================================
    public function store(Request $request, $id_proyecto)
    {
        $total =
            $request->costo_unitario *
            $request->cantidad;

        DB::table('materia_prima')->insert([

            'id_proyecto' =>
                $id_proyecto,

            'nombre_articulo' =>
                $request->nombre_articulo,

            'tipo' =>
                $request->tipo,

            'descripcion' =>
                $request->descripcion,

            'costo_unitario' =>
                $request->costo_unitario,

            'cantidad' =>
                $request->cantidad,

            'total' =>
                $total,

            'estado' => 1,

            'usuario_creacion' => 'admin',

            'fecha_creacion' => now()

        ]);

        return redirect(
            "/admon/proyecto/$id_proyecto/materiaprima"
        )->with(
            'success',
            'Registro agregado correctamente'
        );
    }

    // =========================================
    // EDITAR
    // =========================================
    public function edit($id_proyecto, $id_mp)
    {
        $fila = DB::table('materia_prima')
            ->where('id_mp', $id_mp)
            ->where('id_proyecto', $id_proyecto)
            ->first();

        return view(
            'cpanel.materiaprima.editmateriaprima',
            compact('fila', 'id_proyecto')
        );
    }

    // =========================================
    // ACTUALIZAR
    // =========================================
    public function update(Request $request, $id_proyecto, $id_mp)
    {
        $total =
            $request->costo_unitario *
            $request->cantidad;

        DB::table('materia_prima')
            ->where('id_mp', $id_mp)
            ->where('id_proyecto', $id_proyecto)
            ->update([

                'nombre_articulo' =>
                    $request->nombre_articulo,

                'tipo' =>
                    $request->tipo,

                'descripcion' =>
                    $request->descripcion,

                'costo_unitario' =>
                    $request->costo_unitario,

                'cantidad' =>
                    $request->cantidad,

                'total' =>
                    $total,

                'usuario_modificacion' => 'admin',

                'fecha_modificacion' => now()

            ]);

        return redirect(
            "/admon/proyecto/$id_proyecto/materiaprima"
        )->with(
            'success',
            'Registro actualizado correctamente'
        );
    }

    // =========================================
    // ELIMINAR
    // =========================================
    public function destroy($id_proyecto, $id_mp)
    {
        DB::table('materia_prima')
            ->where('id_mp', $id_mp)
            ->where('id_proyecto', $id_proyecto)
            ->update([
                'estado' => 0
            ]);

        return redirect(
            "/admon/proyecto/$id_proyecto/materiaprima"
        )->with(
            'success',
            'Registro eliminado correctamente'
        );
    }

    // =========================================
    // API GEO
    // =========================================
    public function buscarLugar($material)
    {
        $apiKey = env('GEOAPIFY_API_KEY');

        $lat = session('latitud', '19.0414');
        $lon = session('longitud', '-98.2063');

        $response = Http::timeout(10)->get(
            'https://api.geoapify.com/v1/geocode/search',
            [
                'text' => $material,
                'bias' => 'proximity:' . $lon . ',' . $lat,
                'limit' => 1,
                'lang' => 'es',
                'apiKey' => $apiKey
            ]
        );

        if (!$response->successful()) {

            return [
                'lugar' => 'Error API',
                'lat' => '19.0414',
                'lon' => '-98.2063'
            ];
        }

        $data = $response->json();

        if (isset($data['features'][0])) {

            $place =
                $data['features'][0]['properties'];

            return [
                'lugar' =>
                    $place['formatted'],

                'lat' =>
                    $place['lat'],

                'lon' =>
                    $place['lon']
            ];
        }

        return [
            'lugar' => 'No encontrado',
            'lat' => '19.0414',
            'lon' => '-98.2063'
        ];
    }
}