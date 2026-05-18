@extends('cpanel.plantilla')

@section('title','Formulario Inversión')

@section('content')

<div class="container-fluid py-4">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body p-5">

                    <h3 class="text-center text-primary mb-4">
                        {{ isset($fila) ? 'Editar Inversión' : 'Registrar Inversión' }}
                    </h3>

                    <form action="{{ isset($fila)
                        ? route('inversion.update', [$id_proyecto, $fila->id_inversion])
                        : route('inversion.store', $id_proyecto) }}"
                        method="POST">

                        @csrf

                        @if(isset($fila))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label>Aportación en especie</label>
                            <input type="number"
                                   step="0.01"
                                   name="aportacion_especie"
                                   id="aportacion_especie"
                                   class="form-control"
                                   value="{{ old('aportacion_especie', $fila->aportacion_especie ?? 0) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Aportación en efectivo</label>
                            <input type="number"
                                   step="0.01"
                                   name="aportacion_efectivo"
                                   id="aportacion_efectivo"
                                   class="form-control"
                                   value="{{ old('aportacion_efectivo', $fila->aportacion_efectivo ?? 0) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Total inversión</label>
                            <input type="text"
                                   id="total_inversion"
                                   class="form-control bg-light"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label>Tasa de descuento (%)</label>
                            <input type="number"
                                   step="0.01"
                                   name="tasa_descuento"
                                   class="form-control"
                                   value="{{ old('tasa_descuento', $fila->tasa_descuento ?? 10) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Depreciación</label>
                            <input type="number"
                                   step="0.01"
                                   name="depreciacion"
                                   class="form-control"
                                   value="{{ old('depreciacion', $fila->depreciacion ?? 0) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Años de proyección</label>
                            <input type="number"
                                   name="años_proyeccion"
                                   class="form-control"
                                   value="{{ old('años_proyeccion', $fila->años_proyeccion ?? 5) }}"
                                   min="1"
                                   required>
                        </div>

                        <div class="d-flex gap-2 mt-4">

                            <a href="/admon/proyecto/{{ $id_proyecto }}/inversion"
                               class="btn btn-secondary w-50">
                                Regresar
                            </a>

                            <button class="btn btn-primary w-50">
                                Guardar
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
function calcularTotal(){
    let especie = parseFloat(document.getElementById('aportacion_especie').value) || 0;
    let efectivo = parseFloat(document.getElementById('aportacion_efectivo').value) || 0;

    document.getElementById('total_inversion').value =
        '$' + (especie + efectivo).toFixed(2);
}

document.getElementById('aportacion_especie').addEventListener('input', calcularTotal);
document.getElementById('aportacion_efectivo').addEventListener('input', calcularTotal);

calcularTotal();
</script>

@endsection