@extends('cpanel/plantilla')
@section('title','Registro de Ventas Anuales')
@section('content')

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card-body w-50">

        <form action="{{ url('/admon/ventasanuales') }}" method="POST">
            @csrf

            <div class="main-container">
                <div class="content">
                    <div class="container">
                        <div class="form-container p-4 rounded shadow" style="background: #ffffffcc;">
                            <div class="d-flex justify-content-center mb-4">
                                <h1 class="text-center">Registro de Ventas Anuales</h1>
                            </div>

                            @include('cpanel.ventasanuales.form')

                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>

@endsection