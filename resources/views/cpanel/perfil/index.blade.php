@extends('cpanel.plantilla')

@section('content')

<div class="container mt-4">

    <h3>Perfil del Usuario</h3>

    <!-- FOTO -->
    <div class="mb-3">
        <img 
            src="{{ session('usuario')->foto 
                ? asset('storage/' . session('usuario')->foto) 
                : asset('assets/images/faces/mujer.png') }}" 
            width="120"
            class="rounded-circle"
        >
    </div>

    <!-- SUBIR FOTO -->
    <form method="POST" action="{{ route('perfil.foto') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="foto" required>
        <button class="btn btn-primary mt-2">Actualizar Foto</button>
    </form>

    <!-- ELIMINAR FOTO -->
    <form method="POST" action="{{ route('perfil.foto.eliminar') }}">
        @csrf
        <button class="btn btn-danger mt-2">Eliminar Foto</button>
    </form>

    <!-- DATOS -->
    <div class="mt-4">
        <p><strong>Nombre:</strong> {{ session('usuario')->nombre }}</p>
        <p><strong>Correo:</strong> {{ session('usuario')->correo }}</p>
    </div>

</div>
<h4>Cambiar contraseña</h4>

<form method="POST" action="{{ route('password.cambiar') }}">
    @csrf

    <input type="password" name="actual" placeholder="Contraseña actual" class="form-control mb-2">

    <input type="password" name="nueva" placeholder="Nueva contraseña" class="form-control mb-2">

    <input type="password" name="confirmar" placeholder="Confirmar contraseña" class="form-control mb-2">

    <button class="btn btn-primary">Cambiar contraseña</button>
</form>
@endsection