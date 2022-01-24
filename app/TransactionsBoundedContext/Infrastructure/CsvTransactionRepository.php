<?php

namespace App\TransactionsBoundedContext\Infrastructure;

use App\TransactionsBoundedContext\Domain\TransactionRepository;

class CsvTransactionRepository implements TransactionRepository
{
    public function findAll(): array
    {
        return [];
    }
}
