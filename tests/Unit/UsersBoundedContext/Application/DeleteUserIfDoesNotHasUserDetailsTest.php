<?php

namespace Tests\Unit\UsersBoundedContext\Application;

use App\UsersBoundedContext\Application\DeleteUserIfDoesNotHasUserDetails;
use App\UsersBoundedContext\Application\DeleteUserIfDoesNotHasUserDetailsRequest;
use App\UsersBoundedContext\Domain\User;
use App\UsersBoundedContext\Domain\UserNotFoundException;
use App\UsersBoundedContext\Domain\UserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use Tests\Traits\UsersBoundedContext\CreateUserTrait;

class DeleteUserIfDoesNotHasUserDetailsTest extends TestCase
{
    use ProphecyTrait,
        CreateUserTrait;

    private UserRepository|ObjectProphecy $repository;
    private DeleteUserIfDoesNotHasUserDetails $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->prophesize(UserRepository::class);
        $this->sut = new DeleteUserIfDoesNotHasUserDetails($this->repository->reveal());
    }

    public function test_throws_an_exception_when_NO_user_found(): void
    {
        $this->expectException(UserNotFoundException::class);

        $this->repository->find(Argument::type('int'))
            ->willThrow(new UserNotFoundException);
        $userId = 123;
        $request = new DeleteUserIfDoesNotHasUserDetailsRequest($userId);
        $this->sut->__invoke($request);
    }

    public function test_is_NOT_able_to_delete_user_when_user_details_does_not_exists(): void
    {
        /** @var MethodProphecy $repositoryExpectation */
        $repositoryExpectation = $this->repository->find(Argument::type('int'))
            ->willReturn($this->createUserWithoutUserDetails());
        /** @var MethodProphecy $repositoryDeleteExpectation */
        $repositoryDeleteExpectation = $this->repository->delete(Argument::type(User::class));
        $userId = 123;
        $request = new DeleteUserIfDoesNotHasUserDetailsRequest($userId);
        $result = $this->sut->__invoke($request);

        $repositoryExpectation->shouldBeCalledOnce();
        $repositoryDeleteExpectation->shouldNotBeCalled();
        $this->assertFalse($result->hasBeenDeleted());
    }

    public function test_is_able_to_delete_user_when_user_details_exists(): void
    {
        /** @var MethodProphecy $repositoryExpectation */
        $repositoryExpectation = $this->repository->find(Argument::type('int'))
            ->willReturn($this->createUserWithUserDetails());
        /** @var MethodProphecy $repositoryDeleteExpectation */
        $repositoryDeleteExpectation = $this->repository->delete(Argument::type(User::class));

        $userId = 123;
        $request = new DeleteUserIfDoesNotHasUserDetailsRequest($userId);
        $result = $this->sut->__invoke($request);

        $repositoryExpectation->shouldBeCalledOnce();
        $repositoryDeleteExpectation->shouldBeCalledOnce();
        $this->assertTrue($result->hasBeenDeleted());
    }
}
