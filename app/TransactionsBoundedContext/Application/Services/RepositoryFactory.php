<?php

namespace App\TransactionsBoundedContext\Application\Services;

use App\TransactionsBoundedContext\Domain\RepositoryType;
use App\TransactionsBoundedContext\Domain\SourceNotValidException;
use App\TransactionsBoundedContext\Domain\TransactionRepository;
use App\TransactionsBoundedContext\Infrastructure\CsvTransactionRepository;
use App\TransactionsBoundedContext\Infrastructure\MysqlTransactionRepository;

class RepositoryFactory
{
    public function create(string $type): TransactionRepository
    {
        switch ($type) {
            case RepositoryType::DATABASE:
                return new MysqlTransactionRepository();
            case RepositoryType::CSV:
                return new CsvTransactionRepository();
        }

        throw new SourceNotValidException();
    }
}