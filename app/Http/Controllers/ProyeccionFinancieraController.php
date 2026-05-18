<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyeccionFinancieraController extends Controller
{
    public function index($id_proyecto)
    {
        session(['id_proyecto_actual' => $id_proyecto]);

        $proyecto = DB::table('proyecto')
            ->where('id_proyecto', $id_proyecto)
            ->first();

        $proyecciones = DB::table('proyeccion_financiera')
            ->where('id_proyecto', $id_proyecto)
            ->orderBy('anio')
            ->get();

        return view('cpanel.proyeccion.index', compact(
            'proyecto',
            'proyecciones',
            'id_proyecto'
        ));
    }

    public function create($id_proyecto)
    {
        return view('cpanel.proyeccion.form', compact('id_proyecto'));
    }

    public function store(Request $request, $id_proyecto)
    {
        DB::table('proyeccion_financiera')
            ->where('id_proyecto', $id_proyecto)
            ->delete();

        $ventas = $request->ventas_iniciales;
        $anios = $request->anios;

        for ($anio = 1; $anio <= $anios; $anio++) {

            $costoVentas = $ventas * ($request->porcentaje_costo / 100);
            $gastosOperacion = $ventas * ($request->porcentaje_gastos / 100);

            $utilidadAntes = $ventas - $costoVentas - $gastosOperacion;

            $isrPtu = $utilidadAntes > 0
                ? $utilidadAntes * ($request->porcentaje_impuestos / 100)
                : 0;

            DB::table('proyeccion_financiera')->insert([
                'id_proyecto' => $id_proyecto,
                'anio' => $anio,
                'ventas' => $ventas,
                'costo_ventas' => $costoVentas,
                'gastos_operacion' => $gastosOperacion,
                'isr_ptu' => $isrPtu,
            ]);

            $ventas = $ventas * (1 + ($request->crecimiento / 100));
        }

        return redirect("/admon/proyecto/$id_proyecto/proyeccion")
            ->with('success', 'Proyección generada correctamente');
    }

    public function destroy($id_proyecto, $id_proyeccion)
    {
        DB::table('proyeccion_financiera')
            ->where('id_proyeccion', $id_proyeccion)
            ->where('id_proyecto', $id_proyecto)
            ->delete();

        return redirect("/admon/proyecto/$id_proyecto/proyeccion")
            ->with('success', 'Registro eliminado correctamente');
    }
}