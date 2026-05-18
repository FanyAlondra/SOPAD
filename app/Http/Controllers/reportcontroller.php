<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MateriaPrimaExport;

class ReportController extends Controller
{
    public function GenerarPDF()
    {
        $eventos = DB::table('eventos')->get();

        return PDF::loadView('cpanel.reportes.pdf1', ['data' => $eventos])
                  ->stream('reporte.pdf');
    }

    public function GenerarExcelMateriaPrima()
    {
        return Excel::download(new MateriaPrimaExport, 'reporte_materiaprima.xlsx');
    }
}
