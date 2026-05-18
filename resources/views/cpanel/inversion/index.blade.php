@extends('cpanel.plantilla')

@section('title','Inversión')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold text-primary">
                Inversión
            </h2>

            <p class="text-muted">
                Proyecto: {{ $proyecto->nom_proyecto ?? 'Sin proyecto' }}
            </p>
        </div>

        @if(!$inversion)
            <a href="/admon/proyecto/{{ $id_proyecto }}/inversion/create"
               class="btn btn-primary rounded-pill px-4 shadow">
                ➕ Registrar Inversión
            </a>
        @endif

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow border-0 rounded-4">
        <div class="card-body">

            @if($inversion)

                @php
                    $total = $inversion->aportacion_especie + $inversion->aportacion_efectivo;
                @endphp

                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>Concepto</th>
                            <th>Monto</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Aportación en especie</td>
                            <td>${{ number_format($inversion->aportacion_especie, 2) }}</td>
                        </tr>

                        <tr>
                            <td>Aportación en efectivo</td>
                            <td>${{ number_format($inversion->aportacion_efectivo, 2) }}</td>
                        </tr>

                        <tr>
                            <td>Total inversión</td>
                            <td class="fw-bold text-primary">
                                ${{ number_format($total, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <td>Tasa de descuento</td>
                            <td>{{ $inversion->tasa_descuento }}%</td>
                        </tr>

                        <tr>
                            <td>Depreciación</td>
                            <td>${{ number_format($inversion->depreciacion, 2) }}</td>
                        </tr>

                        <tr>
                            <td>Años de proyección</td>
                            <td>{{ $inversion->años_proyeccion }}</td>
                        </tr>
                    </tbody>

                </table>

                <div class="d-flex gap-2 mt-3">

                    <a href="/admon/proyecto/{{ $id_proyecto }}/inversion/{{ $inversion->id_inversion }}/edit"
                       class="btn btn-warning rounded-pill px-4">
                        ✏️ Editar
                    </a>

                    <form action="{{ route('inversion.destroy', [$id_proyecto, $inversion->id_inversion]) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger rounded-pill px-4"
                                onclick="return confirm('¿Eliminar inversión?')">
                            🗑 Eliminar
                        </button>

                    </form>

                </div>

            @else

                <div class="text-center text-muted py-5">
                    No hay inversión registrada para este proyecto.
                </div>

            @endif

        </div>
    </div>

</div>

@endsection