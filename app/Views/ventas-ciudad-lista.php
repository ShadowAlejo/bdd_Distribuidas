<?php
// app/Views/ventas-ciudad-lista.php
// Variables esperadas: $ciudad, $ventas (array)
?>
<section class="ventas-ciudad">
    <h3>Ventas de <?php echo htmlspecialchars(ucfirst($ciudad), ENT_QUOTES, 'UTF-8'); ?></h3>

    <?php include __DIR__ . '/ventas-ciudad-form.php'; ?>

    <table class="tabla-ventas" id="tabla-ventas-ciudad">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <tr data-id="<?php echo htmlspecialchars($venta['id'] ?? $venta['id_ventas_quito'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <td><?php echo htmlspecialchars($venta['id'] ?? $venta['id_ventas_quito'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($venta['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($venta['cliente'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($venta['monto'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <button class="btn-editar">Editar</button>
                        <button class="btn-eliminar">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
