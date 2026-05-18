@extends('cpanel/plantilla')
@section('title','Inicio')
@section('content')

<table class="table">
    <thead>
        <tr>
            <th>Sel</th>
            <th>ID</th>
            <th>Nombre Del Evento</th>
            <th>Etapa</th>
            <th>Periodo</th>
            <th>Convocatoria</th>
            <th>Descripcion_eventos</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $fila)
        <tr>
            <td> </td>
            <td>{{ $fila->id_evento }}</td>
            <td>{{ $fila->nombre_evento }}</td>
            <td>{{ $fila->etapa }}</td>
            <td>{{ $fila->periodo }}</td>
            <td>{{ $fila->convocatoria }}</td>
            <td>{{ $fila->descripcion_evento }}</td>
            
            <td>
                <a href="{{ url('/admon/eventos/'.$fila->id_evento.'/edit')}}" class="btn btn-outline-primary">E</a>
               
                <form action="{{ route('eventos.destroy', $fila->id_evento) }}" method="post" style="display: inline;">
                    @csrf
                   {{ method_field('DELETE')}}
                    <input class="btn btn-outline-primary" type="submit" onclick="return confirm('¿Estás seguro de eliminar este evento?')" value ="B">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ url('admon/reporte/pdf1') }}" target="_blank" class="btn btn-primary">Generar reporte</a>

@endsection