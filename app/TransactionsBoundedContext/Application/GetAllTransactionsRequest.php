<?php

namespace App\TransactionsBoundedContext\Application;

class GetAllTransactionsRequest
{
    private string $source;

    public function __construct(string $source)
    {
        $this->source = $source;
    }

    public function getSource(): string
    {
        return $this->source;
    }
}
