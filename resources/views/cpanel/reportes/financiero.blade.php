@extends('cpanel/plantilla')

@section('title', 'Registro de Ventas Anuales')

@section('content')

<style>
    body {
        font-family: Arial;
        padding: 20px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #2c3e50;
        color: white;
    }

    .btn {
        background-color: green;
        color: white;
        padding: 10px;
        border-radius: 5px;
        text-decoration: none;
    }
</style>

<h2>Reporte Financiero</h2>

<a href="{{ url('/reporte-financiero/exportar') }}" class="btn">
    Exportar a Excel
</a>

<br><br>

<table>
    <thead>
        <tr>
            <th>Año</th>
            <th>Materia Prima</th>
            <th>Costo MP</th>
            <th>Labor</th>
            <th>Costo Labor</th>
            <th>Ventas</th>
            <th>Costo Total</th>
            <th>Utilidad</th>
        </tr>
    </thead>

    <tbody>
        @forelse($reporte as $r)
            <tr>
                <td>{{ $r->anno }}</td>
                <td>{{ $r->nombre_articulo ?? 'N/A' }}</td>
                <td>${{ number_format($r->total_mp ?? 0, 2) }}</td>
                <td>{{ $r->operario ?? 'N/A' }}</td>
                <td>${{ number_format($r->total_labor ?? 0, 2) }}</td>
                <td>${{ number_format($r->anual ?? 0, 2) }}</td>
                <td>${{ number_format($r->costo_total ?? 0, 2) }}</td>
                <td>
                    @if(($r->utilidad ?? 0) >= 0)
                        <span style="color: green;">
                    @else
                        <span style="color: red;">
                    @endif
                        ${{ number_format($r->utilidad ?? 0, 2) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No hay datos disponibles</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection