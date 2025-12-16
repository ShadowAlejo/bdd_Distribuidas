<?php
// app/Views/ventas-ciudad-form.php
// Variables esperadas: $ciudad
?>
<form id="form-venta-ciudad" class="ventas-form">
    <input type="hidden" name="id" id="venta-id">
    <input type="hidden" name="ciudad" id="venta-ciudad" value="<?php echo htmlspecialchars($ciudad, ENT_QUOTES, 'UTF-8'); ?>">

    <label>
        Fecha
        <input type="date" name="fecha" id="venta-fecha" required>
    </label>

    <label>
        Cliente
        <input type="text" name="cliente" id="venta-cliente" required>
    </label>

    <label>
        Monto
        <input type="number" step="0.01" name="monto" id="venta-monto" required>
    </label>

    <div class="ventas-form-actions">
        <button type="submit" id="btn-guardar">Guardar</button>
        <button type="button" id="btn-limpiar">Limpiar</button>
    </div>
</form>
