@extends('cpanel/plantilla')
@section('title','Registro de usuarios')
@section('content')

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
   <div class="card-body w-50"> {{-- Ajusta el ancho aquí (w-50 = 50%, puedes cambiar a w-75 o w-100) --}}
    
    <form action="{{ url('/admon/usuarios') }}" class="signuForm" method="post">
        @csrf

        <div class="main-container">
            <div class="content">
                <div class="container">
                    <div class="form-container p-4 rounded shadow" style="background: #ffffffcc;">
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <h1 class="text-center" id="registro">Registro de Usuario</h1>
                        </div>
                        @include('cpanel/usuarios/form');
                      
                    </div>
                </div>
            </div>
        </div>
    </form>
   </div>
</div>

@endsection
