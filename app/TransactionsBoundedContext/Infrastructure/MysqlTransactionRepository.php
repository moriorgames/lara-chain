<?php

namespace App\TransactionsBoundedContext\Infrastructure;

use App\TransactionsBoundedContext\Domain\TransactionRepository;

class MysqlTransactionRepository implements TransactionRepository
{
    public function findAll(): array
    {
        return [];
    }
}
