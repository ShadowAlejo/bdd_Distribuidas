<?php
// app/Views/ventas-global-lista.php
// Variable esperada: $ventas (array)
$ventas = $ventas ?? [];
?>

<form id="form-filtros-globales" class="filters-bar">
    <div class="filter-group">
        <label for="filtro-ciudad-global">Ciudad</label>
        <select id="filtro-ciudad-global" name="ciudad">
            <option value="">Todas</option>
            <option value="Quito">Quito</option>
            <option value="Cuenca">Cuenca</option>
            <option value="Guayaquil">Guayaquil</option>
        </select>
    </div>

    <div class="filter-group">
        <label for="filtro-cliente-global">Cliente</label>
        <input id="filtro-cliente-global" name="cliente" type="text" placeholder="Nombre cliente">
    </div>

    <div class="filter-group">
        <label for="filtro-fecha-desde">Desde</label>
        <input id="filtro-fecha-desde" name="fecha_desde" type="date">
    </div>

    <div class="filter-group">
        <label for="filtro-fecha-hasta">Hasta</label>
        <input id="filtro-fecha-hasta" name="fecha_hasta" type="date">
    </div>

    <div class="filter-group">
        <label for="filtro-monto-order">Monto</label>
        <select id="filtro-monto-order" name="monto_order">
            <option value="">Sin orden</option>
            <option value="desc">Mayor a menor</option>
            <option value="asc">Menor a mayor</option>
        </select>
    </div>

    <div class="filter-actions">
        <button type="submit" class="btn-primary">Aplicar filtros</button>
        <button type="button" id="btn-limpiar-filtros" class="btn-secondary">Limpiar</button>
    </div>
</form>

<div class="table-scroll">
    <table class="tabla-ventas" id="tabla-ventas-global">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ciudad</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Origen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <?php
                    // Ajusta estos nombres según tu JSON/SQL real (ideal: estandarizar en el modelo)
                    $id = $venta['idventasquito'] ?? $venta['id_ventas_quito'] ?? '';
                    $origen = $venta['origenservidor'] ?? $venta['origen_servidor'] ?? '';
                ?>
                <tr>
                    <td><?php echo htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($venta['ciudad'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($venta['fecha'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($venta['cliente'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($venta['monto'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars((string)$origen, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>