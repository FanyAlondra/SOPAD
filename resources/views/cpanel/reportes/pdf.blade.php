<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de usuarios</title>

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

<h1>Reporte de usuarios</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>A. Paterno</th>
            <th>A. Materno</th>
            <th>Correo</th>
            
            <th>Rol</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $fila)
        <tr>
            <td>{{ $fila->id_usuario }}</td>
            <td>{{ $fila->nombre }}</td>
            <td>{{ $fila->apellido_p }}</td>
            <td>{{ $fila->apellido_m }}</td>
            <td>{{ $fila->correo }}</td>
     
            <td>{{ $fila->rol }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
