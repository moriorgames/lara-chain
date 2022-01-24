<?php

namespace App\UsersBoundedContext\Infrastructure;

use App\SharedKernel\Infrastructure\MysqlConnection;
use App\UsersBoundedContext\Domain\User;
use App\UsersBoundedContext\Domain\UserDetails;
use App\UsersBoundedContext\Domain\UserNotFoundException;
use App\UsersBoundedContext\Domain\UserRepository;
use DateTime;
use PDO;

class MysqlUserRepository implements UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new MysqlConnection)->getPdo();
    }

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function find(int $id): User
    {
        $params = ['user_id' => $id];
        $sql = <<< SQL
SELECT *, u.id AS user_id, ud.id AS user_details_id
FROM users u
LEFT JOIN user_details ud ON u.id = ud.user_id
LEFT JOIN countries c ON c.id = ud.citizenship_country_id
WHERE u.id = :user_id
SQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetch();
        if (!isset($data['user_id']) || $data['user_id'] === null) {
            throw new UserNotFoundException;
        }
        $userDetails = null;
        if (isset($data['citizenship_country_id'])) {
            $userDetails = new UserDetails(
                $data['user_details_id'],
                $data['user_id'],
                $data['citizenship_country_id'],
                $data['first_name'],
                $data['last_name'],
                $data['phone_number']
            );
        }

        return new User(
            $data['user_id'],
            $data['email'],
            $data['active'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at']),
            $userDetails
        );
    }

    public function findAllActiveWithAustrianCitizenship(): array
    {
        $params = [];
        // @TODO I guess this SQL query implementation is not Ok I will check later
        $sql = <<< SQL
SELECT *
FROM users u
INNER JOIN user_details ud ON u.id = ud.user_id
INNER JOIN countries c ON c.id = ud.citizenship_country_id
WHERE active = 1 AND c.name = 'Austria'
SQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll();
        $result = [];
        foreach ($data as $d) {
            $result[] = new User(
                $d['id'],
                $d['email'],
                $d['active'],
                new DateTime($d['created_at']),
                new DateTime($d['updated_at'])
            );
        }

        return $result;
    }

    /**
     * @param User $user
     * @todo this implementation is fake and must be resolved in next changes
     */
    public function save(User $user): void
    {
        $userDetails = $user->getUserDetails();
        $sql = <<< SQL
UPDATE `user_details` 
SET `citizenship_country_id` = :citizenship_country_id,
    `first_name` = :first_name,
    `last_name` = :last_name,
    `phone_number` = :phone_number
WHERE `id` = :id;
SQL;
        $params = [
            'citizenship_country_id' => $userDetails->getCitizenshipCountryId(),
            'first_name' => $userDetails->getFirstName(),
            'last_name' => $userDetails->getLastName(),
            'phone_number' => $userDetails->getPhoneNumber(),
            'id' => $userDetails->getId()
        ];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    /**
     * @param User $user
     * @todo this method must be implemented later
     */
    public function delete(User $user): void
    {
        $sql = <<< SQL
DELETE u, ud
FROM users u
INNER JOIN user_details ud ON ud.user_id = u.id
WHERE u.id = :user_id;
SQL;
        $params = [
            'user_id' => $user->getId(),
        ];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
}
