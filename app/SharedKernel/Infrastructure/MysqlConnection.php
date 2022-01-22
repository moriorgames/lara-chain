<?php

namespace App\SharedKernel\Infrastructure;

use PDO;
use PDOException;

class MysqlConnection
{
    private PDO $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                getenv('DB_DSN'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD')
            );
        } catch (PDOException $e) {
            // report error message
            echo $e->getMessage();
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
