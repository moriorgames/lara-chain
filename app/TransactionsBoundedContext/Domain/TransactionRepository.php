<?php

namespace App\TransactionsBoundedContext\Domain;

interface TransactionRepository
{
    public function findAll(): array;
}