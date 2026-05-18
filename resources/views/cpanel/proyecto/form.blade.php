@extends('cpanel.plantilla') 

@section('title','Registro de Proyecto')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9 col-md-11">

            <div class="card shadow-lg border-0">
                <div class="card-body p-5">

                    <h3 class="text-center mb-4 text-secondary">
                        {{ isset($fila) ? 'Editar Proyecto' : 'Registro de Proyecto' }}
                    </h3>

                    <form 
                        action="{{ isset($fila) ? route('proyecto.update', $fila->id_proyecto) : route('proyecto.store') }}" 
                        method="POST">

                        @csrf
                        @if(isset($fila))
                            @method('PUT')
                        @endif

                        {{-- NOMBRE --}}
                        <div class="mb-4">
                            <label class="form-label">Nombre del Proyecto</label>
                            <input type="text" class="form-control"
                                   name="nom_proyecto"
                                   value="{{ old('nom_proyecto', $fila->nom_proyecto ?? '') }}"
                                   required>
                        </div>

                        {{-- DESCRIPCIÓN --}}
                        <div class="mb-4">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      rows="3"
                                      required>{{ old('descripcion', $fila->descripcion ?? '') }}</textarea>
                        </div>

                        <div class="row">
                            {{-- FECHA --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Fecha</label>
                                <input type="date" class="form-control"
                                       name="fecha"
                                       value="{{ old('fecha', $fila->fecha ?? '') }}"
                                       required>
                            </div>

                            {{-- USUARIO --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Usuario</label>
                                <select class="form-select" name="id_usuario" required>

                                    <option value="">Seleccione un usuario</option>

                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id_usuario }}"
                                            {{ old('id_usuario', $fila->id_usuario ?? '') == $usuario->id_usuario ? 'selected' : '' }}>
                                            
                                            {{ $usuario->nombre ?? ('Usuario ' . $usuario->id_usuario) }}

                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        {{-- BOTÓN --}}
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ isset($fila) ? 'Actualizar Proyecto' : 'Registrar Proyecto' }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection