<?php

namespace App\UsersBoundedContext\Infrastructure;

use App\SharedKernel\Infrastructure\MysqlConnection;
use App\UsersBoundedContext\Domain\User;
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
     * @todo this implementation is fake and must be resolved in next changes
     * @throw UserNotFoundException
     */
    public function find(int $id): User
    {
        return new User(
            1,
            'email',
            true,
            new DateTime(),
            new DateTime()
        );
    }

    public function findAllActiveWithAustrianCitizenship(): array
    {
        $params = [];
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

        return [];
    }

    /**
     * @param User $user
     * @todo this implementation is fake and must be resolved in next changes
     */
    public function save(User $user): void
    {
    }
}
