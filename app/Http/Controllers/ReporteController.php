<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReporteController extends Controller
{
    public function GenerarPDF()
    {
        $eventos = DB::table('eventos')->get();

        return PDF::loadView('cpanel.reportes.pdf1', ['data' => $eventos])
                  ->stream('reporte.pdf');
    }
}

