<?php
// app/Models/VentaGlobal.php

namespace App\Models;

use App\Core\Model;
use PDO;

class VentaGlobal extends Model
{
    protected string $connectionName = 'bdd_central';
    protected string $view = 'vista_ventas_global'; // nombre de la vista en tu BDD

    public function findAll(): array
    {
        $pdo = $this->getConnection($this->connectionName);
        $sql = "SELECT id_ventas_quito,  
                ciudad, 
                fecha, 
                cliente, 
                monto, 
                origen_servidor

                FROM {$this->view}
                ORDER BY fecha DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByFilters(array $filtros): array
    {
        $pdo = $this->getConnection($this->connectionName);

        $where = [];
        $params = [];

        if (!empty($filtros['ciudad'])) {
            $where[] = 'ciudad = :ciudad';
            $params['ciudad'] = $filtros['ciudad'];
        }

        if (!empty($filtros['cliente'])) {
            $where[] = 'cliente LIKE :cliente';
            $params['cliente'] = '%' . $filtros['cliente'] . '%';
        }

        if (!empty($filtros['fecha_desde'])) {
            $where[] = 'fecha >= :fecha_desde';
            $params['fecha_desde'] = $filtros['fecha_desde'];
        }

        if (!empty($filtros['fecha_hasta'])) {
            $where[] = 'fecha <= :fecha_hasta';
            $params['fecha_hasta'] = $filtros['fecha_hasta'];
        }

        // ORDER BY (default)
        $orderBy = ' ORDER BY fecha ASC';

        // Orden por monto
        if (!empty($filtros['monto_order'])) {
            $dir = strtolower($filtros['monto_order']) === 'asc' ? 'ASC' : 'DESC';
            $orderBy = " ORDER BY monto $dir";
        }

        $sql = "SELECT id_ventas_quito, ciudad, fecha, cliente, monto, origen_servidor
                FROM {$this->view}";

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= $orderBy;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
