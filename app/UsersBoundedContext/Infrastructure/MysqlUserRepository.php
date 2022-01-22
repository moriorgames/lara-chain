<?php

namespace App\UsersBoundedContext\Infrastructure;

use App\UsersBoundedContext\Domain\UserRepository;

class MysqlUserRepository implements UserRepository
{
    public function findAllActiveWithAustrianCitizenship(): array
    {
        return [];
    }
}
