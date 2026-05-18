@extends('cpanel/plantilla')
@section('title','Inicio')
@section('content')

<table class="table">
    <thead>
        <tr>
            <th>Sel</th>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido P</th>
            <th>Apellido M</th>
            <th>Correo</th>
            <th>Contraseña</th>
            <th>Rol</th>
            <th>Acciones</th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $fila)
        <tr>
            <td> </td>
            <td>{{ $fila->id_usuario }}</td>
            <td>{{ $fila->nombre }}</td>
            <td>{{ $fila->apellido_p }}</td>
            <td>{{ $fila->apellido_m }}</td>
            <td>{{ $fila->correo }}</td>
            <td>{{ str_repeat('*', 10) }}</td>            
            <td>{{ $fila->rol }}</td>
            
            <td>
                
                <a href="{{ url('/admon/usuarios/'.$fila->id_usuario.'/edit')}}" class="btn btn-outline-primary">E</a>
               
                <form action="{{ route('usuarios.destroy', $fila->id_usuario) }}" method="post" style="display: inline;">
                    @csrf
                   {{ method_field('DELETE')}}
                    <input class="btn btn-outline-primary" type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" value ="B">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
<a href="{{ URL('admon/reportes/pdf ')}}" target="_blank" class="btn btn-primary" > Generar reporte</a>

@endsection