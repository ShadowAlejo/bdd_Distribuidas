<?php
// app/Core/Router.php

namespace App\Core;

class Router
{
    protected array $routes = [];

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(string $uri): void
    {
        // Quitar query string
        $uri = strtok($uri, '?');

        // Quitar la carpeta base (por ejemplo /dashboard-ventas/public)
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // /dashboard-ventas/public
        if ($basePath !== '' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        // Normalizar URI
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        if (!isset($this->routes[$uri])) {
            http_response_code(404);
            echo '404 - Página no encontrada';
            return;
        }

        $route = $this->routes[$uri];

        $controllerName = $route['controller'] ?? 'Home';
        $actionName     = $route['action'] ?? 'index';

        $controllerClass = 'App\\Controllers\\' . $controllerName . 'Controller';

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo 'Controlador no encontrado';
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $actionName)) {
            http_response_code(500);
            echo 'Acción no encontrada';
            return;
        }

        $controller->{$actionName}();
}

}
