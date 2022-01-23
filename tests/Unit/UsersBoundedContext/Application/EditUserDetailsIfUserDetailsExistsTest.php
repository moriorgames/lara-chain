<?php

namespace Tests\Unit\UsersBoundedContext\Application;

use App\UsersBoundedContext\Application\EditUserDetailsIfUserDetailsExists;
use App\UsersBoundedContext\Application\EditUserDetailsIfUserDetailsExistsRequest;
use App\UsersBoundedContext\Domain\User;
use App\UsersBoundedContext\Domain\UserNotFoundException;
use App\UsersBoundedContext\Domain\UserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use Tests\Traits\UsersBoundedContext\CreateUserTrait;

class EditUserDetailsIfUserDetailsExistsTest extends TestCase
{
    use ProphecyTrait,
        CreateUserTrait;

    private UserRepository|ObjectProphecy $repository;
    private EditUserDetailsIfUserDetailsExists $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->prophesize(UserRepository::class);
        $this->sut = new EditUserDetailsIfUserDetailsExists($this->repository->reveal());
    }

    public function test_throws_an_exception_when_NO_user_found(): void
    {
        $this->expectException(UserNotFoundException::class);

        $this->repository->find(Argument::type('int'))
            ->willThrow(new UserNotFoundException);
        $userId = 123;
        $request = new EditUserDetailsIfUserDetailsExistsRequest($userId);
        $this->sut->__invoke($request);
    }

    public function test_is_NOT_able_to_edit_user_details_when_user_has_no_user_details(): void
    {
        /** @var MethodProphecy $repositoryExpectation */
        $repositoryExpectation = $this->repository->find(Argument::type('int'))
            ->willReturn($this->createUserWithoutUserDetails());
        /** @var MethodProphecy $repositorySaveExpectation */
        $repositorySaveExpectation = $this->repository->save(Argument::type(User::class));
        $userId = 123;
        $request = new EditUserDetailsIfUserDetailsExistsRequest($userId);
        $result = $this->sut->__invoke($request);

        $repositoryExpectation->shouldBeCalledOnce();
        $repositorySaveExpectation->shouldNotBeCalled();
        $this->assertFalse($result->hasBeenEdited());
    }

    public function test_is_able_to_edit_user_details_when_user_has_user_details(): void
    {
        /** @var MethodProphecy $repositoryExpectation */
        $repositoryExpectation = $this->repository->find(Argument::type('int'))
            ->willReturn($this->createUserWithUserDetails());
        /** @var MethodProphecy $repositorySaveExpectation */
        $repositorySaveExpectation = $this->repository->save(Argument::type(User::class));
        $userId = 123;
        $request = new EditUserDetailsIfUserDetailsExistsRequest($userId);
        $result = $this->sut->__invoke($request);

        $repositoryExpectation->shouldBeCalledOnce();
        $repositorySaveExpectation->shouldBeCalledOnce();
        $this->assertTrue($result->hasBeenEdited());
    }
}
