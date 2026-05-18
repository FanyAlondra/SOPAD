@extends('cpanel/plantilla')
@section('title','Registro de eventos')

@section('content')
<form action="{{ url('/admon/eventos') }}" method="post" class="signuForm">
    @csrf

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">

                   @include('cpanel/eventos/form');
                </div>
            </div>
        </div>
    </div>
</form>
@endsection