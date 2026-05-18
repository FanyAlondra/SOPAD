<form method="POST" action="{{ route('login.process') }}">
    @csrf

    <div class="mb-3">
        <label for="correo" class="form-label">Correo institucional</label>
        <input 
            type="email" 
            id="correo" 
            name="correo" 
            class="form-control"
            placeholder="tu.correo@smartin.tecnm.mx"
            required
        >
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-control"
            required
        >
   </div>

<button type="submit" class="btn btn-primary w-100">Ingresar</button>

<div class="text-center mt-3">
    <a href="{{ route('register') }}" class="btn btn-link">
        ¿Aún no estás registrado? Regístrate aquí
    </a>
</div>

</form>
