<?php

namespace App\TransactionsBoundedContext\Infrastructure;

use App\SharedKernel\Infrastructure\MysqlConnection;
use App\TransactionsBoundedContext\Domain\TransactionRepository;
use PDO;

class MysqlTransactionRepository implements TransactionRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new MysqlConnection)->getPdo();
    }

    public function findAll(): array
    {
        $sql = 'SELECT * FROM transactions';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }
}
