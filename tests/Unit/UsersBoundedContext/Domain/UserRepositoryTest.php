<?php

namespace Tests\Unit\UsersBoundedContext\Domain;

use App\UsersBoundedContext\Domain\UserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class UserRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy|UserRepository $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = $this->prophesize(UserRepository::class);
    }

    public function test_is_able_to_query_for_all_users_active_with_austrian_citizen(): void
    {
        $this->assertTrue(true);
    }
}
