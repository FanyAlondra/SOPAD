@extends('cpanel.plantilla')

@section('title','Labor Directa')

@section('content')

<div class="container mt-4">

<div class="card">
<div class="card-body">

<div class="d-flex justify-content-between mb-3">

<h3>Labor Directa</h3>

<a href="{{ route('labordirecta.create') }}" class="btn btn-primary">
Nuevo Registro
</a>

</div>


<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>
<th>ID</th>
<th>Operario</th>
<th>Diseñador</th>
<th>Costo Directo</th>
<th>Total</th>
<th width="180">Acciones</th>
</tr>

</thead>

<tbody>

@if(count($datos) > 0)

@foreach($datos as $fila)

<tr>

<td>{{ $fila->id_labor }}</td>
<td>{{ $fila->operario }}</td>
<td>{{ $fila->disenador }}</td>
<td>{{ $fila->costo_directo }}</td>
<td>{{ $fila->total }}</td>

<td>

<a href="{{ route('labordirecta.edit',$fila->id_labor) }}" class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('labordirecta.destroy',$fila->id_labor) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('¿Seguro que deseas eliminar este registro?')">
Eliminar
</button>

</form>

</td>

</tr>

@endforeach

@else

<tr>
<td colspan="6" class="text-center">
No hay registros
</td>
</tr>

@endif

</tbody>

</table>

</div>
</div>

</div>

@endsection