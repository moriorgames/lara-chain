<?php

namespace Tests\Traits\UsersBoundedContext;

use App\UsersBoundedContext\Domain\User;
use App\UsersBoundedContext\Domain\UserDetails;
use DateTime;

trait CreateUserTrait
{
    protected function createUserWithoutUserDetails(): User
    {
        return new User(123, 'fake@email.com', true, new DateTime, new DateTime);
    }

    protected function createUserWithUserDetails(): User
    {
        $userDetails = new UserDetails(
            456,
            123,
            2,
            'fake first name',
            'fake last name',
            'fake phone number'
        );
        return new User(1, 'fake@email.com', true, new DateTime, new DateTime, $userDetails);
    }
}
