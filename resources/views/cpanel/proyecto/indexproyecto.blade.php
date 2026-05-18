@extends('cpanel.plantilla')
@section('title','Proyectos')
@section('content')

<h2>Proyectos</h2>

<a href="{{ route('proyecto.create') }}" class="btn btn-success mb-3">Registrar Proyecto</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre del Proyecto</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $fila)
        <tr>
            <td>{{ $fila->id_proyecto }}</td>
            <td>{{ $fila->nom_proyecto }}</td>
            <td>{{ $fila->descripcion }}</td>
            <td>{{ $fila->fecha }}</td>
            <td>
                <a href="{{ route('proyecto.edit',$fila->id_proyecto) }}" class="btn btn-primary btn-sm">E</a>

                <form action="{{ route('proyecto.destroy',$fila->id_proyecto) }}" method="POST" style="display:inline;">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este proyecto?')" value="B">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection