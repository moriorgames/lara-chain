<?php

namespace App\TransactionsBoundedContext\Application;

use App\TransactionsBoundedContext\Domain\Transaction;

class GetAllTransactionsResponse
{
    private array $data;

    public function __construct(string $source)
    {
        $this->data['source'] = $source;
    }

    public function add(array $transactionData)
    {
        $this->data[] = $transactionData;
    }

    public function getJson(): string
    {
        return json_encode($this->data);
    }
}