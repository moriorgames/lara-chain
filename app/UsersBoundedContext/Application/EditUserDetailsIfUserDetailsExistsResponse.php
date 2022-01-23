<?php

namespace App\UsersBoundedContext\Application;

class EditUserDetailsIfUserDetailsExistsResponse
{
    private bool $hasBeenEdited;

    public function __construct(bool $hasBeenEdited)
    {
        $this->hasBeenEdited = $hasBeenEdited;
    }

    public function hasBeenEdited(): bool
    {
        return $this->hasBeenEdited;
    }
}
