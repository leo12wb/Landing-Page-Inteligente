<?php

declare(strict_types=1);

namespace App\Support;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getConnection(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $host    = $_ENV['DB_HOST']     ?? 'db';
        $port    = $_ENV['DB_PORT']     ?? '3306';
        $name    = $_ENV['DB_DATABASE'] ?? 'devflow';
        $user    = $_ENV['DB_USERNAME'] ?? 'devflow';
        $pass    = $_ENV['DB_PASSWORD'] ?? '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            self::$instance = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            Logger::error('Database connection failed', ['message' => $e->getMessage()]);
            throw new \RuntimeException('Falha na conexão com o banco de dados.');
        }

        return self::$instance;
    }

    /** Reseta a conexão (útil em testes). */
    public static function reset(): void
    {
        self::$instance = null;
    }
}
