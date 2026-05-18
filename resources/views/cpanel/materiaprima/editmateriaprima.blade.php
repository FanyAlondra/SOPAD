@extends('cpanel/plantilla')
@section('title','editar')
@section('content')

<form action="{{ url('/admon/materiaprima/'.$fila->id_mp) }}" method="post">
    @csrf
    {{ method_field('PATCH') }}
        @include('cpanel/materiaprima/form');
</form>
@endsection