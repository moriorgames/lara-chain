<?php

namespace App\UsersBoundedContext\Application;

class DeleteUserIfDoesNotHasUserDetailsResponse
{
    private bool $hasBeenDeleted;

    public function __construct(bool $hasBeenEdited)
    {
        $this->hasBeenDeleted = $hasBeenEdited;
    }

    public function hasBeenDeleted(): bool
    {
        return $this->hasBeenDeleted;
    }
}