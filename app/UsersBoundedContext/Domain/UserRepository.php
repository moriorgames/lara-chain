<?php

namespace App\UsersBoundedContext\Domain;

interface UserRepository
{
    /**
     * @throw UserNotFoundException
     * @param int $id
     * @return User
     */
    public function find(int $id): User;

    public function findAllActiveWithAustrianCitizenship(): array;

    public function save(User $user): void;

    public function delete(User $user): void;
}
