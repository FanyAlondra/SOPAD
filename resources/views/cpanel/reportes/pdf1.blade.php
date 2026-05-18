<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Eventos</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #ddd;
        }
    </style>
</head>
<body>

<h1>Reporte de Eventos</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre del Evento</th>
            <th>Etapa</th>
            <th>Periodo</th>
            <th>Convocatoria</th>
            <th>Descripción del Evento</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $fila)
        <tr>
            <td>{{ $fila->id_evento }}</td>
            <td>{{ $fila->nombre_evento }}</td>
            <td>{{ $fila->etapa }}</td>
            <td>{{ $fila->periodo }}</td>
            <td>{{ $fila->convocatoria }}</td>
            <td>{{ $fila->descripcion_evento }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
