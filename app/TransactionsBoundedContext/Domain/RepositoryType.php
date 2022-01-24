<?php

namespace App\TransactionsBoundedContext\Domain;

use MyCLabs\Enum\Enum;

class RepositoryType extends Enum
{
    public const DATABASE = 'db';
    public const CSV = 'csv';
}
