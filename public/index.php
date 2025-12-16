<?php
// public/index.php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Ruta base del proyecto
define('BASE_PATH', dirname(__DIR__));

// Autoload muy sencillo para la carpeta app/
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/app/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Cargar rutas
$routes = require BASE_PATH . '/config/routes.php';

// Usar el router
$uri = $_SERVER['REQUEST_URI'] ?? '/';

// Limpiar query string
$uri = strtok($uri, '?');

$router = new App\Core\Router($routes);
$router->dispatch($uri);

$scriptName = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', ($scriptName === '' ? '/' : $scriptName . '/'));