<?php

namespace App\UsersBoundedContext\Domain;

use DateTime;

class User
{
    public function __construct(int $id, string $email, bool $active, DateTime $created_at, DateTime $updated_at)
    {
    }
}
