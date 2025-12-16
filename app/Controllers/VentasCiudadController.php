<?php
// app/Controllers/VentasCiudadController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\VentaQuito;
use App\Models\VentaCuenca;
use App\Models\VentaGuayaquil;

class VentasCiudadController extends Controller
{
    protected function getModelByCiudad(string $ciudad)
    {
        switch (strtolower($ciudad)) {
            case 'quito':
                return new VentaQuito();
            case 'cuenca':
                return new VentaCuenca();
            case 'guayaquil':
                return new VentaGuayaquil();
            default:
                throw new \InvalidArgumentException('Ciudad no soportada');
        }
    }

    // Muestra dashboard con lista inicial de una ciudad (por defecto Quito)
    public function index(): void
    {
        $ciudad = $_GET['ciudad'] ?? 'quito';
        $model = $this->getModelByCiudad($ciudad);
        $ventas = $model->findAll();

        $this->render('ventas-ciudad-lista', [
            'ciudad' => $ciudad,
            'ventas' => $ventas,
        ]);
    }

    // Devuelve ventas en JSON para AJAX
    public function listJson(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $ciudad = $_GET['ciudad'] ?? 'quito';
        $model = $this->getModelByCiudad($ciudad);

        echo json_encode([
            'ciudad' => $ciudad,
            'data'   => $model->findAll(),
        ]);
    }

    public function store(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $ciudad = $_POST['ciudad'] ?? 'quito';
        $model  = $this->getModelByCiudad($ciudad);

        $data = [
            'fecha'   => $_POST['fecha']   ?? null,
            'cliente' => $_POST['cliente'] ?? null,
            'monto'   => $_POST['monto']   ?? null,
        ];

        $id = $model->create($data);

        echo json_encode(['ok' => true, 'id' => $id]);
    }

    public function update(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $ciudad = $_POST['ciudad'] ?? 'quito';
        $model  = $this->getModelByCiudad($ciudad);

        $id = (int)($_POST['id'] ?? 0);

        $data = [
            'fecha'   => $_POST['fecha']   ?? null,
            'cliente' => $_POST['cliente'] ?? null,
            'monto'   => $_POST['monto']   ?? null,
        ];

        $ok = $model->update($id, $data);

        echo json_encode(['ok' => $ok]);
    }

    public function delete(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $ciudad = $_POST['ciudad'] ?? 'quito';
        $model  = $this->getModelByCiudad($ciudad);

        $id = (int)($_POST['id'] ?? 0);

        $ok = $model->delete($id);

        echo json_encode(['ok' => $ok]);
    }
}
