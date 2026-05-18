@extends('cpanel.plantilla')

@section('title','Registro de Materia Prima')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9 col-md-11">

            <div class="card shadow-lg border-0">
                <div class="card-body p-5">

                    <h3 class="text-center mb-4 text-secondary">
                        Registro de Materia Prima
                    </h3>

                    <form 
                        action="{{ isset($fila) 
                            ? route('materiaprima.update', [$id_proyecto, $fila->id_mp]) 
                            : route('materiaprima.store', $id_proyecto) }}" 
                        method="POST"
                        id="materiaPrimaForm">

                        @csrf

                        @if(isset($fila))
                            @method('PUT')
                        @endif

                        {{-- TIPO --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Tipo de Materia
                            </label>

                            @php 
                                $tipo = old('tipo', $fila->tipo ?? '') 
                            @endphp

                            <select class="form-select" name="tipo" required>

                                <option value="">
                                    Selecciona un tipo
                                </option>

                                <option value="metal"
                                    {{ $tipo=='metal' ? 'selected' : '' }}>
                                    Metal
                                </option>

                                <option value="plastico"
                                    {{ $tipo=='plastico' ? 'selected' : '' }}>
                                    Plástico
                                </option>

                                <option value="madera"
                                    {{ $tipo=='madera' ? 'selected' : '' }}>
                                    Madera
                                </option>

                                <option value="textil"
                                    {{ $tipo=='textil' ? 'selected' : '' }}>
                                    Textil
                                </option>

                                <option value="electronico"
                                    {{ $tipo=='electronico' ? 'selected' : '' }}>
                                    Electrónico
                                </option>

                                <option value="quimico"
                                    {{ $tipo=='quimico' ? 'selected' : '' }}>
                                    Químico
                                </option>

                                <option value="otro"
                                    {{ $tipo=='otro' ? 'selected' : '' }}>
                                    Otro
                                </option>

                            </select>

                        </div>

                        {{-- NOMBRE --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Nombre del Artículo
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="nombre_articulo"
                                   value="{{ old('nombre_articulo', $fila->nombre_articulo ?? '') }}"
                                   required>

                        </div>

                        {{-- DESCRIPCIÓN --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Descripción
                            </label>

                            <textarea class="form-control"
                                      name="descripcion"
                                      rows="3"
                                      required>{{ old('descripcion', $fila->descripcion ?? '') }}</textarea>

                        </div>

                        <div class="row">

                            {{-- COSTO --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label">
                                    Costo Unitario
                                </label>

                                <input type="number"
                                       class="form-control"
                                       id="costo_unitario"
                                       name="costo_unitario"
                                       value="{{ old('costo_unitario', $fila->costo_unitario ?? '') }}"
                                       step="0.01"
                                       min="0"
                                       required>

                            </div>

                            {{-- CANTIDAD --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label">
                                    Cantidad
                                </label>

                                <input type="number"
                                       class="form-control"
                                       id="cantidad"
                                       name="cantidad"
                                       value="{{ old('cantidad', $fila->cantidad ?? 1) }}"
                                       min="1"
                                       required>

                            </div>

                        </div>

                        {{-- TOTAL --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Total
                            </label>

                            <input type="number"
                                   class="form-control bg-light"
                                   id="total"
                                   name="total"
                                   value="{{ old('total', $fila->total ?? '') }}"
                                   readonly>

                        </div>

                        {{-- BOTONES --}}
                        <div class="d-flex justify-content-between gap-3 mt-4">

                            {{-- REGRESAR --}}
                            <a href="/admon/proyecto/{{ $id_proyecto }}/materiaprima"
                               class="btn btn-secondary btn-lg w-50">

                                ← Regresar

                            </a>

                            {{-- GUARDAR --}}
                            <button type="submit"
                                    class="btn btn-primary btn-lg w-50">

                                {{ isset($fila) 
                                    ? 'Actualizar Materia Prima' 
                                    : 'Registrar Materia Prima' }}

                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- JS TOTAL --}}
<script>

    function calcularTotal() {

        let costo =
            parseFloat(
                document.getElementById('costo_unitario').value
            ) || 0;

        let cantidad =
            parseInt(
                document.getElementById('cantidad').value
            ) || 0;

        document.getElementById('total').value =
            (costo * cantidad).toFixed(2);
    }

    document
        .getElementById('costo_unitario')
        .addEventListener('input', calcularTotal);

    document
        .getElementById('cantidad')
        .addEventListener('input', calcularTotal);

    calcularTotal();

</script>

@endsection