<?php

namespace Tests\Unit\UsersBoundedContext\Application;

use App\UsersBoundedContext\Application\GetAllActiveUsersWithAustrianCitizenshipUseCase;
use App\UsersBoundedContext\Domain\UserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use Tests\Traits\UsersBoundedContext\CreateUserTrait;

class GetAllActiveUsersWithAustrianCitizenshipUseCaseTest extends TestCase
{
    use ProphecyTrait,
        CreateUserTrait;

    private UserRepository|ObjectProphecy $repository;
    private GetAllActiveUsersWithAustrianCitizenshipUseCase $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->prophesize(UserRepository::class);
        $this->sut = new GetAllActiveUsersWithAustrianCitizenshipUseCase($this->repository->reveal());
    }

    public function test_is_able_to_return_all_active_users_with_austrian_citizenship_only_one(): void
    {
        $userRepositoryReturn = [$this->createUserWithUserDetails()];
        /** @var MethodProphecy $repositoryExpectation */
        $repositoryExpectation = $this->repository->findAllActiveWithAustrianCitizenship()
            ->willReturn($userRepositoryReturn);

        $result = $this->sut->__invoke();

        $this->assertCount(count($userRepositoryReturn), $result->getAllUsers());
        $repositoryExpectation->shouldBeCalledOnce();
    }

    public function test_is_able_to_return_all_active_users_with_austrian_citizenship_more_than_one(): void
    {
        $userRepositoryReturn = [$this->createUserWithUserDetails(), $this->createUserWithUserDetails(), $this->createUserWithUserDetails()];
        /** @var MethodProphecy $repositoryExpectation */
        $repositoryExpectation = $this->repository->findAllActiveWithAustrianCitizenship()
            ->willReturn($userRepositoryReturn);

        $result = $this->sut->__invoke();

        $this->assertCount(count($userRepositoryReturn), $result->getAllUsers());
        $repositoryExpectation->shouldBeCalledOnce();
    }
}
