<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReporteFinancieroExport implements FromCollection, WithEvents, ShouldAutoSize
{
    public function collection()
    {
        return collect([]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // ===============================
                // DATOS DE BASE DE DATOS
                // ===============================

                $inversion = DB::table('inversion')->first();
                $proyeccion = DB::table('proyeccion_financiera')->orderBy('anio')->get();

                $materias = DB::table('materia_prima')
                    ->select('nombre_articulo', 'tipo', 'cantidad', 'costo_unitario', 'total')
                    ->where('estado', 1)
                    ->get();

                $labor = DB::table('labor_directa')
                    ->select('operario', 'disenador', 'costo_directo', 'total')
                    ->get();

                $ventas = DB::table('ventas_anuales')
                    ->select('anno', 'num_articulo', 'costo_unitario', 'mensual', 'anual')
                    ->where('estado', 1)
                    ->get();

                // ===============================
                // CÁLCULOS GENERALES
                // ===============================

                $aportacionEspecie = $inversion->aportacion_especie ?? 0;
                $aportacionEfectivo = $inversion->aportacion_efectivo ?? 0;
                $tasa = $inversion->tasa_descuento ?? 0;
                $depreciacion = $inversion->depreciacion ?? 0;

                $totalInversion = $aportacionEspecie + $aportacionEfectivo;

                $totalMP = $materias->sum('total');
                $totalLabor = $labor->sum('total');
                $totalVentas = $ventas->sum('anual');
                $costoTotal = $totalMP + $totalLabor;
                $utilidad = $totalVentas - $costoTotal;

                // ===============================
                // TÍTULO GENERAL
                // ===============================

                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'REPORTE FINANCIERO GENERAL');

                $sheet->mergeCells('A2:F2');
                $sheet->setCellValue('A2', 'Sistema SOPAD - Evaluación Financiera de Proyectos');

                $sheet->mergeCells('A3:F3');
                $sheet->setCellValue('A3', 'Fecha de generación: ' . date('d/m/Y'));

                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'color' => ['rgb' => '1F364A']
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ],
                ]);

                $sheet->getStyle('A2:F3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '1F364A']
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ],
                ]);

                // ===============================
                // INVERSIÓN
                // ===============================

                $row = 5;

                $this->titulo($sheet, $row, 'INVERSIÓN');
                $row++;

                $sheet->fromArray([
                    ['Concepto', 'Monto'],
                    ['Aportación en Especie', $aportacionEspecie],
                    ['Aportación en Efectivo', $aportacionEfectivo],
                    ['Total Inversión', $totalInversion],
                    ['Tasa de Descuento', $tasa . '%'],
                    ['Depreciación', $depreciacion],
                ], null, "A{$row}");

                $this->tabla($sheet, "A{$row}:B" . ($row + 5));

                $sheet->getStyle("B" . ($row + 1) . ":B" . ($row + 3))
                    ->getNumberFormat()
                    ->setFormatCode('$#,##0.00');

                $sheet->getStyle("B" . ($row + 5))
                    ->getNumberFormat()
                    ->setFormatCode('$#,##0.00');

                $row += 8;

                // ===============================
                // RESUMEN FINANCIERO
                // ===============================

                $this->titulo($sheet, $row, 'RESUMEN FINANCIERO');
                $row++;

                $sheet->fromArray([
                    ['Concepto', 'Importe'],
                    ['Total Materia Prima', $totalMP],
                    ['Total Labor Directa', $totalLabor],
                    ['Total Ventas Anuales', $totalVentas],
                    ['Costo Total', $costoTotal],
                    ['Utilidad', $utilidad],
                ], null, "A{$row}");

                $this->tabla($sheet, "A{$row}:B" . ($row + 5));

                $sheet->getStyle("B" . ($row + 1) . ":B" . ($row + 5))
                    ->getNumberFormat()
                    ->setFormatCode('$#,##0.00');

                $row += 8;

                // ===============================
                // ESTADO DE RESULTADOS PROYECTADO
                // ===============================

                $this->titulo($sheet, $row, 'ESTADO DE RESULTADOS PROYECTADO');
                $row++;

                $sheet->fromArray([
                    ['', 'AÑO 1', 'AÑO 2', 'AÑO 3', 'AÑO 4', 'AÑO 5']
                ], null, "A{$row}");

                $inicioEstado = $row;
                $row++;

                $ventasArray = [];
                $costoArray = [];
                $gastosArray = [];
                $isrArray = [];
                $utilidadBruta = [];
                $utilidadAntes = [];
                $utilidadNeta = [];
                $flujoEfectivo = [];

                foreach ($proyeccion as $p) {
                    $ventasAnio = $p->ventas ?? 0;
                    $costoVentas = $p->costo_ventas ?? 0;
                    $gastosOperacion = $p->gastos_operacion ?? 0;
                    $isrPtu = $p->isr_ptu ?? 0;

                    $ub = $ventasAnio - $costoVentas;
                    $uai = $ub - $gastosOperacion;
                    $un = $uai - $isrPtu;
                    $flujo = $un + $depreciacion;

                    $ventasArray[] = $ventasAnio;
                    $costoArray[] = $costoVentas;
                    $utilidadBruta[] = $ub;
                    $gastosArray[] = $gastosOperacion;
                    $utilidadAntes[] = $uai;
                    $isrArray[] = $isrPtu;
                    $utilidadNeta[] = $un;
                    $flujoEfectivo[] = $flujo;
                }

                $sheet->fromArray([
                    array_merge(['VENTAS'], $ventasArray),
                    array_merge(['COSTO DE VENTAS'], $costoArray),
                    array_merge(['UTILIDAD BRUTA'], $utilidadBruta),
                    array_merge(['GASTOS DE OPERACIÓN'], $gastosArray),
                    array_merge(['UTILIDAD/PÉRDIDA ANTES DE IMPUESTOS'], $utilidadAntes),
                    array_merge(['ISR Y PTU'], $isrArray),
                    array_merge(['UTILIDAD/PÉRDIDA NETA'], $utilidadNeta),
                    array_merge(['FLUJO DE EFECTIVO'], $flujoEfectivo),
                ], null, "A{$row}");

                $finEstado = $row + 7;

                $this->tabla($sheet, "A{$inicioEstado}:F{$finEstado}");

                $sheet->getStyle("B{$row}:F{$finEstado}")
                    ->getNumberFormat()
                    ->setFormatCode('$#,##0.00');

                // Colores especiales
                $sheet->getStyle("A" . ($row + 2) . ":F" . ($row + 2))->applyFromArray([
                    'fill' => ['fillType' => 'solid', 'color' => ['rgb' => 'D8E4BC']],
                ]);

                $sheet->getStyle("A" . ($row + 6) . ":F" . ($row + 6))->applyFromArray([
                    'fill' => ['fillType' => 'solid', 'color' => ['rgb' => 'D8E4BC']],
                ]);

                $row = $finEstado + 3;

                // ===============================
                // EVALUACIÓN FINANCIERA
                // ===============================

                $this->titulo($sheet, $row, 'EVALUACIÓN FINANCIERA');
                $row++;

                $vpn = -$totalInversion;

                foreach ($flujoEfectivo as $index => $flujo) {
                    $anio = $index + 1;
                    $vpn += $flujo / pow(1 + ($tasa / 100), $anio);
                }

                $sumaFlujos = array_sum($flujoEfectivo);

                $resultado = ($vpn > 0 && $sumaFlujos > $totalInversion)
                    ? 'VIABLE'
                    : 'NO VIABLE';

                $sheet->fromArray([
                    ['Concepto', 'Resultado'],
                    ['Total Inversión', $totalInversion],
                    ['Suma de Flujos', $sumaFlujos],
                    ['VPN', $vpn],
                    ['Resultado Final', $resultado],
                ], null, "A{$row}");

                $this->tabla($sheet, "A{$row}:B" . ($row + 4));

                $sheet->getStyle("B" . ($row + 1) . ":B" . ($row + 3))
                    ->getNumberFormat()
                    ->setFormatCode('$#,##0.00');

                $resultadoRow = $row + 4;

                $sheet->getStyle("B{$resultadoRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => $resultado == 'VIABLE' ? '008000' : 'C00000'],
                    ],
                ]);

                $row += 7;

                // ===============================
                // MATERIA PRIMA
                // ===============================

                $this->titulo($sheet, $row, 'MATERIA PRIMA');
                $row++;

                $sheet->fromArray([
                    ['Artículo', 'Tipo', 'Cantidad', 'Costo Unitario', 'Total']
                ], null, "A{$row}");

                $start = $row;
                $row++;

                foreach ($materias as $m) {
                    $sheet->fromArray([
                        $m->nombre_articulo,
                        $m->tipo,
                        $m->cantidad,
                        $m->costo_unitario,
                        $m->total,
                    ], null, "A{$row}");
                    $row++;
                }

                $sheet->setCellValue("D{$row}", 'TOTAL');
                $sheet->setCellValue("E{$row}", "=SUM(E" . ($start + 1) . ":E" . ($row - 1) . ")");

                $this->tabla($sheet, "A{$start}:E{$row}");

                $sheet->getStyle("D" . ($start + 1) . ":E{$row}")
                    ->getNumberFormat()
                    ->setFormatCode('$#,##0.00');

                $row += 3;

                // ===============================
                // LABOR DIRECTA
                // ===============================

                $this->titulo($sheet, $row, 'LABOR DIRECTA');
                $row++;

                $sheet->fromArray([
                    ['Operario', 'Diseñador', 'Costo Directo', 'Total']
                ], null, "A{$row}");

                $start = $row;
                $row++;

                foreach ($labor as $l) {
                    $sheet->fromArray([
                        $l->operario,
                        $l->disenador,
                        $l->costo_directo,
                        $l->total,
                    ], null, "A{$row}");
                    $row++;
                }

                $sheet->setCellValue("C{$row}", 'TOTAL');
                $sheet->setCellValue("D{$row}", "=SUM(D" . ($start + 1) . ":D" . ($row - 1) . ")");

                $this->tabla($sheet, "A{$start}:D{$row}");

                $sheet->getStyle("C" . ($start + 1) . ":D{$row}")
                    ->getNumberFormat()
                    ->setFormatCode('$#,##0.00');

                $row += 3;

                // ===============================
                // VENTAS ANUALES
                // ===============================

                $this->titulo($sheet, $row, 'VENTAS ANUALES');
                $row++;

                $sheet->fromArray([
                    ['Año', 'Número de Artículos', 'Costo Unitario', 'Mensual', 'Anual']
                ], null, "A{$row}");

                $start = $row;
                $row++;

                foreach ($ventas as $v) {
                    $sheet->fromArray([
                        $v->anno,
                        $v->num_articulo,
                        $v->costo_unitario,
                        $v->mensual,
                        $v->anual,
                    ], null, "A{$row}");
                    $row++;
                }

                $sheet->setCellValue("D{$row}", 'TOTAL');
                $sheet->setCellValue("E{$row}", "=SUM(E" . ($start + 1) . ":E" . ($row - 1) . ")");

                $this->tabla($sheet, "A{$start}:E{$row}");

                $sheet->getStyle("C" . ($start + 1) . ":E{$row}")
                    ->getNumberFormat()
                    ->setFormatCode('$#,##0.00');

                $row += 3;

                // ===============================
                // DICTAMEN FINAL
                // ===============================

                $this->titulo($sheet, $row, 'DICTAMEN FINAL');
                $row++;

                $sheet->mergeCells("A{$row}:F{$row}");

                $sheet->setCellValue(
                    "A{$row}",
                    $resultado == 'VIABLE'
                        ? 'El proyecto es VIABLE porque el VPN es positivo y los flujos superan la inversión inicial.'
                        : 'El proyecto NO ES VIABLE porque el VPN es negativo o los flujos no superan la inversión inicial.'
                );

                $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 13,
                        'color' => ['rgb' => $resultado == 'VIABLE' ? '008000' : 'C00000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN
                        ],
                    ],
                ]);

                // ===============================
                // AJUSTES FINALES
                // ===============================

                $sheet->getColumnDimension('A')->setWidth(42);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(20);

                $sheet->freezePane('A6');
            },
        ];
    }

    private function titulo($sheet, $row, $texto)
    {
        $sheet->mergeCells("A{$row}:F{$row}");
        $sheet->setCellValue("A{$row}", $texto);

        $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 13,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => '386173']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
        ]);
    }

    private function tabla($sheet, $range)
    {
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '999999'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $inicio = explode(':', $range)[0];

        preg_match('/([A-Z]+)([0-9]+)/', $inicio, $match);

        if (!isset($match[2])) {
            return;
        }

        $headerRow = $match[2];

        $sheet->getStyle("A{$headerRow}:F{$headerRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => '1F364A']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
        ]);
    }
}