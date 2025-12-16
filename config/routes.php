<?php
// config/routes.php

return [
    '/' => [
        'controller' => 'Home',
        'action'     => 'index',
    ],

    // Fase 3: CRUD ventas por ciudad
    '/ventas-ciudad' => [
        'controller' => 'VentasCiudad',
        'action'     => 'index',
    ],
    '/ventas-ciudad/list' => [
        'controller' => 'VentasCiudad',
        'action'     => 'listJson',
    ],
    '/ventas-ciudad/store' => [
        'controller' => 'VentasCiudad',
        'action'     => 'store',
    ],
    '/ventas-ciudad/update' => [
        'controller' => 'VentasCiudad',
        'action'     => 'update',
    ],
    '/ventas-ciudad/delete' => [
        'controller' => 'VentasCiudad',
        'action'     => 'delete',
    ],
    
    // Fase 4: reportes globales
    '/ventas-global' => [
        'controller' => 'VentasGlobal',
        'action'     => 'index',
    ],
    '/ventas-global/filter' => [
        'controller' => 'VentasGlobal',
        'action'     => 'filter',
    ],
];
