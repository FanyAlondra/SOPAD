<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-header text-center" style="background-color:#164575; color:white;">
                    <h5>Iniciar Sesión</h5>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Correo institucional</label>
                            <input type="email"
                                   name="correo"
                                   class="form-control"
                                   placeholder="tu.correo@smartin.tecnm.mx"
                                   value="{{ old('correo') }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password"
                                   name="contrasena"
                                   class="form-control"
                                   required>
                        </div>

                        <button class="btn w-100" type="submit"
                                style="background-color:#164575; color:white;">
                            Ingresar
                        </button>
                      
<button type="button"
        onclick="window.location.href='/admon/usuarios/create'">
    Registrarse
</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>