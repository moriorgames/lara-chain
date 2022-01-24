<?php

namespace Tests\Feature\UsersBoundedContext\Application;

use App\SharedKernel\Infrastructure\MysqlConnection;
use App\UsersBoundedContext\Application\DeleteUserIfDoesNotHasUserDetails;
use App\UsersBoundedContext\Application\DeleteUserIfDoesNotHasUserDetailsRequest;
use App\UsersBoundedContext\Domain\User;
use App\UsersBoundedContext\Domain\UserNotFoundException;
use App\UsersBoundedContext\Infrastructure\MysqlUserRepository;
use Tests\TestCase;

class DeleteUserIfDoesNotHasUserDetailsTest extends TestCase
{
    private MysqlUserRepository $repository;
    private DeleteUserIfDoesNotHasUserDetails $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new MysqlUserRepository();
        $this->sut = new DeleteUserIfDoesNotHasUserDetails($this->repository);
        DeleteUserIfDoesNotHasUserDetailsFixtureTestBuilder::build();
    }

    protected function tearDown(): void
    {
        DeleteUserIfDoesNotHasUserDetailsFixtureTestBuilder::destroy();
    }

    public function test_is_NOT_able_to_delete_user_without_user_details(): void
    {
        $userId = DeleteUserIfDoesNotHasUserDetailsFixtureTestBuilder::USER_ID_WITHOUT_USER_DETAILS;
        $request = new DeleteUserIfDoesNotHasUserDetailsRequest($userId);
        $result = $this->sut->__invoke($request);

        $user = $this->repository->find($userId);

        $this->assertFalse($result->hasBeenDeleted());
        $this->assertInstanceOf(User::class, $user);
    }

    public function test_is_able_to_delete_user_that_has_user_details(): void
    {
        $userId = DeleteUserIfDoesNotHasUserDetailsFixtureTestBuilder::USER_ID_WITH_USER_DETAILS;
        $request = new DeleteUserIfDoesNotHasUserDetailsRequest($userId);
        $result = $this->sut->__invoke($request);

        $this->assertTrue($result->hasBeenDeleted());

        $this->expectException(UserNotFoundException::class);
        $this->repository->find($userId);
    }
}

class DeleteUserIfDoesNotHasUserDetailsFixtureTestBuilder
{
    public const USER_ID_WITHOUT_USER_DETAILS = 9987;
    public const USER_ID_WITH_USER_DETAILS = 9986;
    public const USER_DETAILS_ID = 9982;

    public static function build()
    {
        $mysql = new MysqlConnection;
        $pdo = $mysql->getPdo();

        $params = ['user_id' => self::USER_ID_WITHOUT_USER_DETAILS];
        $sql = <<< SQL
INSERT INTO `users` (`id`, `email`, `active`, `created_at`, `updated_at`)
VALUES
	(:user_id, 'alex9987@tempmail.com', 1, '2022-01-01 16:08:59', '2022-01-01 16:08:59');
SQL;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $params = ['user_id' => self::USER_ID_WITH_USER_DETAILS];
        $sql = <<< SQL
INSERT INTO `users` (`id`, `email`, `active`, `created_at`, `updated_at`)
VALUES
	(:user_id, 'alex9986@tempmail.com', 1, '2022-01-01 16:08:59', '2022-01-01 16:08:59');
SQL;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $params = ['user_id' => self::USER_ID_WITH_USER_DETAILS, 'user_details_id' => self::USER_DETAILS_ID];
        $sql = <<< SQL
INSERT INTO `user_details` (`id`, `user_id`, `citizenship_country_id`, `first_name`, `last_name`, `phone_number`)
VALUES
	(:user_details_id, :user_id, 1, 'Morior9982', 'Games9982', '9982666555444');
SQL;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }

    public static function destroy()
    {
        $mysql = new MysqlConnection;
        $pdo = $mysql->getPdo();

        $pdo->prepare('DELETE FROM `users` WHERE `id` = :user_id')
            ->execute(['user_id' => self::USER_ID_WITHOUT_USER_DETAILS]);

        $pdo->prepare('DELETE FROM `users` WHERE `id` = :user_id')
            ->execute(['user_id' => self::USER_ID_WITH_USER_DETAILS]);

        $pdo->prepare('DELETE FROM `user_details` WHERE `id` = :user_details_id')
            ->execute(['user_details_id' => self::USER_DETAILS_ID]);
    }
}
