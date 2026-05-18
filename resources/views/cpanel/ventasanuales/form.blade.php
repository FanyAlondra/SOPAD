<div class="mb-3">

    <!-- SELECT MATERIA PRIMA -->
    <div class="mb-3">
        <label class="form-label">Materia Prima</label>
        <select name="id_mp" id="id_mp" class="form-control" required>
            <option value="">Seleccione</option>

            @foreach ($materias as $m)
                <option value="{{ $m->id_mp }}"
                    data-costo="{{ $m->costo_unitario }}"
                    data-cantidad="{{ $m->cantidad }}">
                    
                    {{ $m->nombre_articulo }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- 🔥 AÑO OCULTO -->
    <input type="hidden" name="anno" value="{{ date('Y') }}">

    <!-- NUM ARTICULOS -->
    <div class="mb-3">
        <label class="form-label">Número de Artículos</label>
        <input type="number" 
            class="form-control" 
            id="num_articulo" 
            name="num_articulo" 
            readonly>
    </div>

    <!-- COSTO -->
    <div class="mb-3">
        <label class="form-label">Costo Unitario</label>
        <input type="number" 
            class="form-control" 
            id="costo_unitario" 
            name="costo_unitario"
            step="0.01" 
            required>
    </div>

    <!-- MENSUAL -->
    <div class="mb-3">
        <label class="form-label">Mensual</label>
        <input type="number" 
            class="form-control" 
            id="mensual" 
            name="mensual"
            step="0.01" 
            readonly>
    </div>

    <!-- ANUAL -->
    <div class="mb-3">
        <label class="form-label">Anual</label>
        <input type="number" 
            class="form-control" 
            id="anual" 
            name="anual"
            step="0.01" 
            readonly>
    </div>

    <button type="submit" class="btn btn-primary w-100">Guardar</button>

</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    function calcular() {
        let num = parseFloat(document.getElementById('num_articulo').value) || 0;
        let costo = parseFloat(document.getElementById('costo_unitario').value) || 0;

        let mensual = num * costo;
        let anual = mensual * 12;

        document.getElementById('mensual').value = mensual.toFixed(2);
        document.getElementById('anual').value = anual.toFixed(2);
    }

    // CUANDO CAMBIAS MATERIA PRIMA
    document.getElementById('id_mp').addEventListener('change', function() {

        let selected = this.options[this.selectedIndex];

        let costo = selected.getAttribute('data-costo');
        let cantidad = selected.getAttribute('data-cantidad') || 0;

        document.getElementById('costo_unitario').value = costo;
        document.getElementById('num_articulo').value = cantidad;

        calcular();
    });

    // EVENTO
    document.getElementById('costo_unitario').addEventListener('input', calcular);

});
</script>