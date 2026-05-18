<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="nombre" value="{{ old('nombre', $fila->nombre ?? ' ') }}" name="nombre"
        placeholder="Ingresa tu nombre" required>
</div>

<div class="mb-3">
    <label for="apellido_p" class="form-label">Apellido Paterno</label>
    <input type="text" class="form-control" id="apellido_p" name="apellido_p"
        value="{{ old('apellido_p', $fila->apellido_p ?? '') }}" placeholder="Ingresa tu apellido paterno" required>
</div>

<div class="mb-3">
    <label for="apellido_m" class="form-label">Apellido Materno</label>
    <input type="text" class="form-control" id="apellido_m" name="apellido_m"
        value="{{ old('apellido_m', $fila->apellido_m ?? '') }}" placeholder="Ingresa tu apellido materno" required>
</div>

<div class="mb-3">
    <label for="correo" class="form-label">Correo</label>
    <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $fila->correo ?? '') }}"
        placeholder="Ingresa tu correo" required pattern="^l[0-9]{8}@smartin\.tecnm\.mx$"
        title="El correo debe ser como: lXXXXXXXX@smartin.tecnm.mx">
</div>


<div class="mb-3">
    <label for="contrasena" class="form-label">Contraseña</label>
    <input type="password" class="form-control" id="contrasena" name="contrasena"
        value="{{ old('contrasena', $fila->contrasena ?? ' ') }}" placeholder="Contraseña" required minlength="8"
        maxlength="15">
</div>

<div class="mb-3">
    <label for="rol" class="form-label">Rol</label>
    <select class="form-select" id="rol" name="rol" value="{{ old('rol', $fila->rol ?? ' ') }}" required>
        <option value="">Selecciona un rol</option>
        <option value="admin">Administrador</option>
        <option value="estudiante">Estudiante</option>
        <option value="profesor">Profesor</option>
    </select>
</div>

<button class="btn btn-primary w-100" type="submit">Enviar Registro</button>