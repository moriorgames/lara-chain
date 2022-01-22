<?php

namespace App\UsersBoundedContext\Domain;

interface UserRepository
{
    public function findAllActiveWithAustrianCitizenship(): array;
}
