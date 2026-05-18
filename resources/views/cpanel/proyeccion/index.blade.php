@extends('cpanel.plantilla')

@section('title','Proyección Financiera')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold text-primary">
                Proyección Financiera
            </h2>

            <p class="text-muted">
                Proyecto: {{ $proyecto->nom_proyecto ?? 'Sin proyecto' }}
            </p>
        </div>

        <a href="/admon/proyecto/{{ $id_proyecto }}/proyeccion/create"
           class="btn btn-primary rounded-pill px-4 shadow">
            ➕ Generar Proyección
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>Año</th>
                            <th>Ventas</th>
                            <th>Costo ventas</th>
                            <th>Gastos operación</th>
                            <th>ISR/PTU</th>
                            <th>Utilidad neta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($proyecciones as $fila)

                            @php
                                $utilidad = $fila->ventas
                                    - $fila->costo_ventas
                                    - $fila->gastos_operacion
                                    - $fila->isr_ptu;
                            @endphp

                            <tr>
                                <td>{{ $fila->anio }}</td>
                                <td>${{ number_format($fila->ventas, 2) }}</td>
                                <td>${{ number_format($fila->costo_ventas, 2) }}</td>
                                <td>${{ number_format($fila->gastos_operacion, 2) }}</td>
                                <td>${{ number_format($fila->isr_ptu, 2) }}</td>

                                <td class="fw-bold {{ $utilidad >= 0 ? 'text-success' : 'text-danger' }}">
                                    ${{ number_format($utilidad, 2) }}
                                </td>

                                <td>
                                    <form action="{{ route('proyeccion.destroy', [$id_proyecto, $fila->id_proyeccion]) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                onclick="return confirm('¿Eliminar registro?')">
                                            🗑
                                        </button>

                                    </form>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No hay proyección registrada.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection