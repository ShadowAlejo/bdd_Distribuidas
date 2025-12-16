<?php
// app/Views/dashboard.php

$ciudad = $ciudad ?? 'quito';
?>
<section class="dashboard">
    <aside class="dashboard-sidebar">
        <h2>Ciudades</h2>
        <select id="selector-ciudad">
            <option value="quito"     <?= $ciudad === 'quito' ? 'selected' : '' ?>>Quito</option>
            <option value="cuenca"    <?= $ciudad === 'cuenca' ? 'selected' : '' ?>>Cuenca</option>
            <option value="guayaquil" <?= $ciudad === 'guayaquil' ? 'selected' : '' ?>>Guayaquil</option>
        </select>

        <nav class="dashboard-menu">
            <button class="tab-button is-active" data-tab="formulario">
                Formulario ventas
            </button>
            <!-- Desabilitando temporalmente hasta arreglar el Js encargado de esta sección
            <button class="tab-button" data-tab="tabla-ciudad">
                Tabla por ciudad
            </button>
            -->
            <button class="tab-button" data-tab="tabla-global">
                Tabla global
            </button>
        </nav>
    </aside>

    <section class="dashboard-content">
        <h2><?php echo htmlspecialchars($titulo ?? 'Dashboard de Ventas', ENT_QUOTES, 'UTF-8'); ?></h2>
        <p>Gestiona las ventas por ciudad y visualiza el consolidado global en tiempo real.</p>

        <!-- TAB: Formulario + tabla por ciudad -->
        <section id="tab-formulario" class="tab-content is-active">
            <div class="ventas-ciudad">
                <?php
                // Formulario reutilizando la vista parcial
                $ciudadForm = $ciudad;
                include __DIR__ . '/ventas-ciudad-form.php';
                ?>

                <div>
                    <h3>Ventas por ciudad</h3>
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
                            <?php if (!empty($ventasCiudad)): ?>
                                <?php foreach ($ventasCiudad as $venta): ?>
                                    <?php
                                    $id = $venta['id'] ??
                                        $venta['id_ventas_quito'] ??
                                        $venta['id_ventas_cuenca'] ??
                                        $venta['id_ventas_guayaquil'] ??
                                        null;
                                    ?>
                                    <tr data-id="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
                                        <td><?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($venta['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($venta['cliente'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($venta['monto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <button class="btn-editar">Editar</button>
                                            <button class="btn-eliminar">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- TAB: tabla por ciudad sola (opcional, si quieres separar) -->
        <section id="tab-tabla-ciudad" class="tab-content">
            <h3>Ventas por ciudad</h3>
            <table class="tabla-ventas" id="tabla-ventas-ciudad-solo">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ventasCiudad)): ?>
                        <?php foreach ($ventasCiudad as $venta): ?>
                            <?php
                            $id = $venta['id'] ??
                                $venta['id_ventas_quito'] ??
                                $venta['id_ventas_cuenca'] ??
                                $venta['id_ventas_guayaquil'] ??
                                null;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($venta['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($venta['cliente'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($venta['monto'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!-- TAB: global -->
        <section id="tab-tabla-global" class="tab-content">
            <div class="ventas-global">
                <div>
                    <?php
                        $ventas = $ventasGlobal ?? [];
                        include __DIR__ . '/ventas-global-lista.php';
                    ?>
                </div>
            </div>
        </section>
    </section>
</section>
