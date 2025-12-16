<?php
// app/Core/Model.php

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Model
{
    /** @var array<string, PDO> */
    protected static array $connections = [];

    /** @var array<string, mixed> */
    protected static array $config = [];

    public function __construct()
    {
        if (empty(self::$config)) {
            $configFile = BASE_PATH . '/config/database.php';

            if (!file_exists($configFile)) {
                throw new RuntimeException('Archivo de configuración de BDD no encontrado.');
            }

            self::$config = require $configFile;
        }
    }

    /**
     * Obtiene una conexión PDO por nombre de conexión: bdd_quito, bdd_cuenca, etc.
     */
    protected function getConnection(string $name = null): PDO
    {
        if ($name === null) {
            $name = self::$config['default'] ?? null;
        }

        if ($name === null || !isset(self::$config[$name])) {
            throw new RuntimeException("Configuración de conexión [$name] no encontrada.");
        }

        if (isset(self::$connections[$name])) {
            return self::$connections[$name];
        }

        $conf = self::$config[$name];

        $driver  = $conf['driver']   ?? 'mysql';
        $host    = $conf['host']     ?? 'localhost';
        $dbname  = $conf['dbname']   ?? '';
        $user    = $conf['user']     ?? '';
        $pass    = $conf['password'] ?? '';
        $charset = $conf['charset']  ?? 'utf8mb4';

        $dsn = "{$driver}:host={$host};dbname={$dbname};charset={$charset}";

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            $this->logError('Error de conexión [' . $name . ']: ' . $e->getMessage());
            throw new RuntimeException('No se pudo conectar a la base de datos [' . $name . '].');
        }

        self::$connections[$name] = $pdo;

        return $pdo;
    }

    /**
     * Método de ayuda para registrar errores en logs/app.log (opcional en esta fase).
     */
    protected function logError(string $message): void
    {
        $logFile = BASE_PATH . '/logs/app.log';

        $entry = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
        @file_put_contents($logFile, $entry, FILE_APPEND);
    }
}
