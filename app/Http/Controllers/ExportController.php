<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteFinancieroExport;
use App\Exports\MateriaPrimaExport;

class ExportController extends Controller
{
    // EXPORTAR REPORTE FINANCIERO
    public function reporteExcel()
    {
        return Excel::download(
            new ReporteFinancieroExport,
            'Reporte_Financiero.xlsx'
        );
    }

    // EXPORTAR MATERIA PRIMA
    public function GenerarExcelMateriaPrima()
    {
        return Excel::download(
            new MateriaPrimaExport,
            'Materia_Prima.xlsx'
        );
    }
}