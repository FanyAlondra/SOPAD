@extends('cpanel/plantilla')
@section('title','editar')
@section('content')

<form action="{{ url('/admon/eventos/'.$fila->id_evento) }}" method="post">
    @csrf
    {{ method_field('PATCH') }}
        @include('cpanel/eventos/form');
</form>
@endsection