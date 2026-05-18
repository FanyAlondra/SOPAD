@extends('cpanel.plantilla')

@section('title','Materia Prima')

@section('content')

<div class="container-fluid py-3">

    <style>
        .tabla-card{
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .table thead{
            background: #212529;
            color: white;
        }

        .table tbody tr:hover{
            background-color: #f8f9fa;
        }

        .mini-pagination .pagination{
            margin: 0;
            gap: 4px;
            font-size: 11px;
            justify-content: center;
        }

        .mini-pagination .page-link{
            padding: 1px 6px !important;
            font-size: 10px !important;
            border-radius: 5px !important;
            color: #0d6efd;
            border: 1px solid #dee2e6;
            min-width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-item:first-child,
        .page-item:last-child{
            display: none !important;
        }

        .mini-pagination svg{
            width: 10px !important;
            height: 10px !important;
        }

        .mini-pagination .page-item.active .page-link{
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .mini-pagination .page-link:hover{
            background-color: #e9ecef;
        }

        .btn-mini{
            padding: 4px 10px;
            font-size: 12px;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold text-primary mb-1">
                Materia Prima
            </h2>

            <p class="text-muted mb-0">
                Administración de materiales
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="/admon/proyecto/{{ $id_proyecto }}/materiaprima/create"
               class="btn btn-primary shadow rounded-pill px-4">
                ➕ Nuevo Registro
            </a>

            <a href="/reporte/materiaprima/excel/{{ $id_proyecto }}"
               class="btn btn-success shadow rounded-pill px-4">
               📥 Descargar Excel
            </a>

        </div>

    </div>

    <div class="card tabla-card shadow-lg">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Costo</th>
                            <th>Total</th>
                            <th>Lugar</th>
                            <th>Mapa</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($data as $fila)

                        <tr>

                            <td>
                                <span class="badge bg-secondary rounded-pill">
                                    {{ $fila->id_mp }}
                                </span>
                            </td>

                            <td class="fw-semibold">
                                {{ $fila->nombre_articulo }}
                            </td>

                            <td>
                                <span class="badge bg-info text-dark rounded-pill">
                                    {{ $fila->tipo }}
                                </span>
                            </td>

                            <td style="max-width:200px; white-space:normal; word-wrap:break-word;">
                                {{ $fila->descripcion }}
                            </td>

                            <td class="text-success fw-bold">
                                ${{ number_format($fila->costo_unitario,2) }}
                            </td>

                            <td class="text-primary fw-bold">
                                ${{ number_format($fila->total,2) }}
                            </td>

                            <td style="max-width:170px; white-space:normal; word-wrap:break-word;">
                                {{ explode(',', $fila->lugar_compra)[0] }}
                            </td>

                            <td>
                                <a href="{{ $fila->maps }}"
                                   target="_blank"
                                   class="btn btn-primary btn-mini rounded-pill">
                                    📍 Mapa
                                </a>
                            </td>

                            <td class="text-center">

                                <a href="/admon/proyecto/{{ $id_proyecto }}/materiaprima/{{ $fila->id_mp }}/edit"
                                   class="btn btn-outline-primary btn-mini rounded-pill">
                                    ✏️
                                </a>

                                <form action="{{ route('materiaprima.destroy', [$id_proyecto, $fila->id_mp]) }}"
                                      method="POST"
                                      style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-danger btn-mini rounded-pill"
                                            onclick="return confirm('¿Eliminar registro?')">
                                        🗑
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No hay registros disponibles
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-center mt-3 mini-pagination">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>

        </div>

    </div>

</div>

<script>
if(navigator.geolocation){
    navigator.geolocation.getCurrentPosition(function(position){
        let lat = position.coords.latitude;
        let lon = position.coords.longitude;

        fetch('/guardar-ubicacion', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                latitud: lat,
                longitud: lon
            })
        });
    });
}
</script>

@endsection