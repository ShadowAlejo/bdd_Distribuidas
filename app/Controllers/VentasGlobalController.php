<?php
// app/Controllers/VentasGlobalController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\VentaGlobal;

class VentasGlobalController extends Controller
{
    protected VentaGlobal $model;

    public function __construct()
    {
        $this->model = new VentaGlobal();
    }

    // Render (si quisieras una vista independiente; opcional si todo es vía AJAX)
    public function index(): void
    {
        $ventas = $this->model->findAll();

        $this->render('ventas-global-lista', [
            'ventas' => $ventas,
        ]);
    }

    // Endpoint JSON para filtros (principal para el dashboard)
    public function filter(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $filtros = [
            'ciudad'       => $_REQUEST['ciudad']       ?? null,
            'cliente'      => $_REQUEST['cliente']      ?? null,
            'fecha_desde'  => $_REQUEST['fecha_desde']  ?? null,
            'fecha_hasta'  => $_REQUEST['fecha_hasta']  ?? null,
            'monto_order'  => $_REQUEST['monto_order']  ?? null, 
        ];

        $ventas = $this->model->findByFilters($filtros);

        echo json_encode([
            'data'    => $ventas,
            'filtros' => $filtros,
        ]);
    }
}
