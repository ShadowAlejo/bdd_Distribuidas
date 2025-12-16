<?php
// app/Views/layout.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Ventas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>
<body>
    <header class="app-header">
        <h1 class="app-title">Dashboard de Ventas</h1>
    </header>

    <main class="app-main">
        <?php
        // Aquí se incluye la vista hija
        if (isset($contentViewFile)) {
            require $contentViewFile;
        }
        ?>
    </main>

    <base href="<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/'; ?>">
    <script src="assets/js/api-ciudades.js"></script>
    <script src="assets/js/filtros-globales.js"></script>
    <script src="assets/js/main.js"></script>
    
</body>
</html>
