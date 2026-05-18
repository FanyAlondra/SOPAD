<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Código</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-header text-center" style="background-color:#164575; color:white;">
                    <h5>Verificación en 2 Pasos</h5>
                </div>

                <div class="card-body">

                    @if (session('codigo'))
                        <div class="alert alert-info text-center">
                            Tu código es: <strong>{{ session('codigo') }}</strong>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('twofactor.verify') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Ingresa el código</label>
                            <input type="text" name="two_factor_code" class="form-control" required>
                        </div>

                        <button class="btn w-100" type="submit"
                                style="background-color:#164575; color:white;">
                            Verificar
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
