<?php
// app/Controllers/HomeController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\VentaQuito;
use App\Models\VentaCuenca;
use App\Models\VentaGuayaquil;
use App\Models\VentaGlobal;

class HomeController extends Controller
{
    public function index(): void
    {
        $ciudad = $_GET['ciudad'] ?? 'quito';

        // Selecciona modelo según ciudad
        switch (strtolower($ciudad)) {
            case 'cuenca':
                $modelCiudad = new VentaCuenca();
                break;
            case 'guayaquil':
                $modelCiudad = new VentaGuayaquil();
                break;
            default:
                $ciudad = 'quito';
                $modelCiudad = new VentaQuito();
                break;
        }

        $ventasCiudad  = $modelCiudad->findAll();
        $modelGlobal   = new VentaGlobal();
        $ventasGlobal  = $modelGlobal->findAll();

        $this->render('dashboard', [
            'titulo'       => 'Dashboard de Ventas',
            'ciudad'       => $ciudad,
            'ventasCiudad' => $ventasCiudad,
            'ventasGlobal' => $ventasGlobal,
        ]);
    }
}
