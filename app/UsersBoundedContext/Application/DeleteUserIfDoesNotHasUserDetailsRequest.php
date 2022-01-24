<?php

namespace App\UsersBoundedContext\Application;

class DeleteUserIfDoesNotHasUserDetailsRequest
{
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
    
    public function getUserId(): int
    {
        return $this->userId;
    }
}