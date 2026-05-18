@extends('cpanel.plantilla')

@section('title','Registro de Eventos')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9 col-md-11">

            <div class="card shadow-lg border-0">
                <div class="card-body p-5">

                    <h3 class="text-center mb-4 text-secondary">
                        Registro de Eventos
                    </h3>

                    {{-- FORMULARIO --}}
                    <form action="{{ route('eventos.store') }}" method="POST">
                        @csrf

                        {{-- NOMBRE --}}
                        <div class="mb-4">
                            <label class="form-label">Nombre del Evento</label>
                            <input type="text" class="form-control"
                                   name="nombre_evento"
                                   value="{{ old('nombre_evento', $fila->nombre_evento ?? '') }}"
                                   required>
                        </div>

                        {{-- ETAPA --}}
                        <div class="mb-4">
                            <label class="form-label">Etapa</label>
                            <select class="form-select" name="etapa" required>
                                <option value="">Seleccione una etapa</option>
                                <option value="cerrada"
                                    {{ old('etapa', $fila->etapa ?? '') == 'cerrada' ? 'selected' : '' }}>
                                    Cerrada
                                </option>
                                <option value="abierta"
                                    {{ old('etapa', $fila->etapa ?? '') == 'abierta' ? 'selected' : '' }}>
                                    Abierta
                                </option>
                            </select>
                        </div>

                        {{-- PERIODO --}}
                        <div class="mb-4">
                            <label class="form-label">Periodo</label>
                            <input type="text" class="form-control"
                                   name="periodo"
                                   placeholder="Ej. 2023-2024"
                                   value="{{ old('periodo', $fila->periodo ?? '') }}"
                                   required>
                        </div>

                        {{-- CONVOCATORIA --}}
                        <div class="mb-4">
                            <label class="form-label d-block mb-2">Convocatoria</label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="convocatoria"
                                       value="ordinaria"
                                       {{ old('convocatoria', $fila->convocatoria ?? '') == 'ordinaria' ? 'checked' : '' }}>
                                <label class="form-check-label">Ordinaria</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="convocatoria"
                                       value="extraordinaria"
                                       {{ old('convocatoria', $fila->convocatoria ?? '') == 'extraordinaria' ? 'checked' : '' }}>
                                <label class="form-check-label">Extraordinaria</label>
                            </div>
                        </div>

                        {{-- DESCRIPCIÓN --}}
                        <div class="mb-4">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control"
                                      name="descripcion_evento"
                                      rows="3"
                                      placeholder="Descripción del evento">{{ old('descripcion_evento', $fila->descripcion_evento ?? '') }}</textarea>
                        </div>

                        {{-- BOTONES --}}
                        <div class="d-grid gap-3 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Registrar Evento
                            </button>

                            <a href="{{ url('/admon/eventos') }}" class="btn btn-outline-secondary">
                                Regresar al listado
                            </a>
                        </div>

                    </form>
                    {{-- FIN FORMULARIO --}}

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
