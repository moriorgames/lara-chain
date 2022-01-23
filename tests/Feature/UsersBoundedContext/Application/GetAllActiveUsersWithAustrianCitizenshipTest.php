<?php

namespace Tests\Feature\UsersBoundedContext\Application;

use App\UsersBoundedContext\Application\GetAllActiveUsersWithAustrianCitizenship;
use App\UsersBoundedContext\Infrastructure\MysqlUserRepository;
use Tests\TestCase;

class GetAllActiveUsersWithAustrianCitizenshipTest extends TestCase
{
    public function test_is_able_to_return_all_active_users_with_austrian_citizenship_from_database(): void
    {
        $sut = new GetAllActiveUsersWithAustrianCitizenship(new MysqlUserRepository());

        $result = $sut->__invoke();

        $this->assertCount(2, $result->getAllUsers());
    }
}
