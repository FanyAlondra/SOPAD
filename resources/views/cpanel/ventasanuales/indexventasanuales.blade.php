@extends('cpanel.plantilla')
@section('title','Ventas Anuales')
@section('content')

<h2>Ventas Anuales</h2>

<a href="{{ route('ventas.create') }}" class="btn btn-success mb-3">Registrar Venta</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Año</th>
            <th>Número de Artículos</th>
            <th>Costo Unitario</th>
            <th>Mensual</th>
            <th>Anual</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $fila)
        <tr>
            <td>{{ $fila->id_venta }}</td>
            <td>{{ $fila->anno }}</td>
            <td>{{ $fila->num_articulo }}</td>
            <td>{{ number_format($fila->costo_unitario, 2) }}</td>
            <td>{{ number_format($fila->mensual, 2) }}</td>
            <td>{{ number_format($fila->anual, 2) }}</td>
            <td>
                <a href="{{ route('ventas.edit',$fila->id_venta) }}" class="btn btn-primary btn-sm">E</a>
                <form action="{{ route('ventas.destroy',$fila->id_venta) }}" method="POST" style="display:inline;">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta venta?')" value="B">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection