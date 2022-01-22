<?php

namespace App\UsersBoundedContext\Application;

use App\UsersBoundedContext\Domain\User;

class GetAllActiveUsersWithAustrianCitizenshipResponse
{
    /** @var User[] */
    private array $users;

    public function add(User $user): void
    {
        $this->users[] = $user;
    }

    public function getAllUsers(): array
    {
        return $this->users;
    }
}
