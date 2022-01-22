<?php

namespace Tests\Traits\UsersBoundedContext;

use App\UsersBoundedContext\Domain\User;
use DateTime;

trait CreateUserTrait
{
    protected function createValidUser(): User
    {
        return new User(1, 'fake@email.com', true, new DateTime, new DateTime);
    }
}
