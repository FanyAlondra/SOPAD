@extends('cpanel.plantilla')

@section('title','Generar Proyección')

@section('content')

<div class="container-fluid py-4">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body p-5">

                    <h3 class="text-center text-primary mb-4">
                        Generar Proyección Financiera
                    </h3>

                    <form action="{{ route('proyeccion.store', $id_proyecto) }}"
                          method="POST">

                        @csrf

                        <div class="mb-3">
                            <label>Ventas iniciales</label>
                            <input type="number"
                                   step="0.01"
                                   name="ventas_iniciales"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Crecimiento anual (%)</label>
                            <input type="number"
                                   step="0.01"
                                   name="crecimiento"
                                   class="form-control"
                                   value="10"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Porcentaje costo de ventas (%)</label>
                            <input type="number"
                                   step="0.01"
                                   name="porcentaje_costo"
                                   class="form-control"
                                   value="50"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Porcentaje gastos de operación (%)</label>
                            <input type="number"
                                   step="0.01"
                                   name="porcentaje_gastos"
                                   class="form-control"
                                   value="30"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>ISR/PTU (%)</label>
                            <input type="number"
                                   step="0.01"
                                   name="porcentaje_impuestos"
                                   class="form-control"
                                   value="30"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Años a proyectar</label>
                            <input type="number"
                                   name="anios"
                                   class="form-control"
                                   value="5"
                                   min="1"
                                   required>
                        </div>

                        <div class="d-flex gap-2 mt-4">

                            <a href="/admon/proyecto/{{ $id_proyecto }}/proyeccion"
                               class="btn btn-secondary w-50">
                                Regresar
                            </a>

                            <button class="btn btn-primary w-50">
                                Generar
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection