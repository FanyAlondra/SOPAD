@extends('cpanel/plantilla')
@section('title','Registro de materia prima')
@section('content')

<div class="main-container d-flex">
    <div class="content">
        <div class="container mt-5">
            <div class="form-container">

                <div class="d-flex align-items-center justify-content-center mb-4">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" width="85" height="70" class="me-3">
                    <h1 class="text-white text-center" id="registro">Registro de Labor Directa </h1>
                </div>

                {{-- Aquí se incluye el formulario --}}
                @include('cpanel.labordirecta.form')

            </div>
        </div>
    </div>
</div>

@endsection
