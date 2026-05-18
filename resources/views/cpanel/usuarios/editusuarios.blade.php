@extends('cpanel/plantilla')
@section('title','editar')
@section('content')

<form action="{{ url('/admon/usuarios/'.$fila->id_usuario) }}" method="post">
    @csrf
    {{ method_field('PATCH') }}
        @include('cpanel/usuarios/form');
</form>
@endsection