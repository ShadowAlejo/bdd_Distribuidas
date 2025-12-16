<?php
// app/Core/Controller.php

namespace App\Core;

class Controller
{
    protected string $layout = 'layout';

    protected function render(string $view, array $data = []): void
    {
        // Variables disponibles en la vista
        extract($data);

        $viewsPath = BASE_PATH . '/app/Views/';

        $layoutFile = $viewsPath . $this->layout . '.php';
        $viewFile   = $viewsPath . $view . '.php';

        if (!file_exists($layoutFile)) {
            throw new \RuntimeException('Layout no encontrado: ' . $layoutFile);
        }

        if (!file_exists($viewFile)) {
            throw new \RuntimeException('Vista no encontrada: ' . $viewFile);
        }

        // Hacer accesible la ruta de la vista al layout
        $contentViewFile = $viewFile;

        require $layoutFile;
    }
}
