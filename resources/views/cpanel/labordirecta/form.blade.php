@extends('cpanel.plantilla')

@section('title','Registro de Labor Directa')

@section('content')

<div class="container mt-4">

<div class="card">
<div class="card-body">

<h3 class="mb-4">Registro de Labor Directa</h3>

<form action="{{ isset($fila) ? route('labordirecta.update',$fila->id_labor) : route('labordirecta.store') }}" method="POST">

@csrf

@if(isset($fila))
@method('PUT')
@endif


<div class="mb-3">
<label class="form-label">Operario</label>
<input type="number" class="form-control" id="operario" name="operario"
value="{{ old('operario',$fila->operario ?? '') }}" required>
</div>


<div class="mb-3">
<label class="form-label">Diseñador</label>
<input type="number" class="form-control" id="disenador" name="disenador"
value="{{ old('disenador',$fila->disenador ?? '') }}" required>
</div>


<div class="mb-3">
<label class="form-label">Costo Directo</label>
<input type="number" class="form-control" name="costo_directo"
value="{{ old('costo_directo',$fila->costo_directo ?? '') }}" required>
</div>


<div class="mb-3">
<label class="form-label">Total</label>
<input type="number" class="form-control" id="total" name="total" readonly
value="{{ old('total',$fila->total ?? '') }}">
</div>


<button class="btn btn-primary">
{{ isset($fila) ? 'Actualizar' : 'Guardar' }}
</button>

<a href="{{ route('labordirecta.index') }}" class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

</div>


<script>

document.addEventListener("DOMContentLoaded", function(){

function calcularTotal(){

let operario = parseFloat(document.getElementById('operario').value) || 0;
let disenador = parseFloat(document.getElementById('disenador').value) || 0;

document.getElementById('total').value = operario + disenador;

}

document.getElementById('operario').addEventListener('input',calcularTotal);
document.getElementById('disenador').addEventListener('input',calcularTotal);

calcularTotal();

});

</script>

@endsection