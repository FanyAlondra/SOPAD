<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function reporteFinanciero()
    {
        $reporte = DB::select('CALL reporte_financiero_completo()');

        return view('cpanel.reportes.financiero', compact('reporte'));
    }
}