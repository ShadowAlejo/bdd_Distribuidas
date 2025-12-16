<?php
// app/Models/VentaCuenca.php

namespace App\Models;

use App\Core\Model;
use PDO;

class VentaCuenca extends Model
{
    protected string $connectionName = 'bdd_cuenca';
    protected string $table = 'ventas'; // ajusta al nombre real

    public function findAll(): array
    {
        $pdo = $this->getConnection($this->connectionName);
        $stmt = $pdo->query("SELECT * FROM {$this->table} ORDER BY fecha DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $pdo = $this->getConnection($this->connectionName);
        $stmt = $pdo->prepare("SELECT * FROM {$this->table} WHERE id_ventas_cuenca = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $pdo = $this->getConnection($this->connectionName);
        $sql = "INSERT INTO {$this->table} (ciudad, fecha, cliente, monto)
                VALUES (:ciudad, :fecha, :cliente, :monto)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'ciudad'  => 'Cuenca',
            'fecha'   => $data['fecha'],
            'cliente' => $data['cliente'],
            'monto'   => $data['monto'],
        ]);
        return (int)$pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $pdo = $this->getConnection($this->connectionName);
        $sql = "UPDATE {$this->table}
                SET fecha = :fecha, cliente = :cliente, monto = :monto
                WHERE id_ventas_cuenca = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'id'      => $id,
            'fecha'   => $data['fecha'],
            'cliente' => $data['cliente'],
            'monto'   => $data['monto'],
        ]);
    }

    public function delete(int $id): bool
    {
        $pdo = $this->getConnection($this->connectionName);
        $stmt = $pdo->prepare("DELETE FROM {$this->table} WHERE id_ventas_cuenca = :id");
        return $stmt->execute(['id' => $id]);
    }
}
