<?php

namespace Tests\Feature\UsersBoundedContext\Application;

use App\SharedKernel\Infrastructure\MysqlConnection;
use App\UsersBoundedContext\Application\EditUserDetailsIfUserDetailsExists;
use App\UsersBoundedContext\Application\EditUserDetailsIfUserDetailsExistsRequest;
use App\UsersBoundedContext\Infrastructure\MysqlUserRepository;
use Tests\TestCase;

class EditUserDetailsIfUserDetailsExistsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        EditUserDetailsIfUserDetailsExistsFixtureTestBuilder::build();
    }

    protected function tearDown(): void
    {
        EditUserDetailsIfUserDetailsExistsFixtureTestBuilder::destroy();
    }

    public function test_is_able_edit_user_details_when_user_details_exists(): void
    {
        $mysqlUserRepository = new MysqlUserRepository();
        $sut = new EditUserDetailsIfUserDetailsExists($mysqlUserRepository);

        $userId = EditUserDetailsIfUserDetailsExistsFixtureTestBuilder::USER_ID;
        $userDetailCitizenshipCountryId = 2;
        $userDetailFirstName = 'Max';
        $userDetailLastName = 'Power';
        $userDetailPhoneNumber = '99993333444';
        $request = new EditUserDetailsIfUserDetailsExistsRequest(
            $userId,
            $userDetailCitizenshipCountryId,
            $userDetailFirstName,
            $userDetailLastName,
            $userDetailPhoneNumber
        );

        $result = $sut->__invoke($request);

        $user = $mysqlUserRepository->find($userId);

        $this->assertTrue($result->hasBeenEdited());
        $this->assertEquals($userDetailCitizenshipCountryId, $user->getUserDetails()->getCitizenshipCountryId());
        $this->assertEquals($userDetailFirstName, $user->getUserDetails()->getFirstName());
        $this->assertEquals($userDetailLastName, $user->getUserDetails()->getLastName());
        $this->assertEquals($userDetailPhoneNumber, $user->getUserDetails()->getPhoneNumber());
    }
}

class EditUserDetailsIfUserDetailsExistsFixtureTestBuilder
{
    public const USER_ID = 9997;
    public const USER_DETAILS_ID = 9992;

    public static function build()
    {
        $mysql = new MysqlConnection;
        $pdo = $mysql->getPdo();

        $params = ['user_id' => self::USER_ID];
        $sql = <<< SQL
INSERT INTO `users` (`id`, `email`, `active`, `created_at`, `updated_at`)
VALUES
	(:user_id, 'alex9997@tempmail.com', 1, '2022-01-01 16:08:59', '2022-01-01 16:08:59');
SQL;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $params = ['user_id' => self::USER_ID, 'user_details_id' => self::USER_DETAILS_ID];
        $sql = <<< SQL
INSERT INTO `user_details` (`id`, `user_id`, `citizenship_country_id`, `first_name`, `last_name`, `phone_number`)
VALUES
	(:user_details_id, :user_id, 1, 'Morior9992', 'Games9992', '9992666555444');
SQL;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }

    public static function destroy()
    {
        $mysql = new MysqlConnection;
        $pdo = $mysql->getPdo();

        $pdo->prepare('DELETE FROM `users` WHERE `id` = :user_id')
            ->execute(['user_id' => self::USER_ID]);

        $pdo->prepare('DELETE FROM `user_details` WHERE `id` = :user_details_id')
            ->execute(['user_details_id' => self::USER_DETAILS_ID]);
    }
}
