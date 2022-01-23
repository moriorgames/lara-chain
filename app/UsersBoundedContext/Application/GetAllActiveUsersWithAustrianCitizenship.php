<?php

namespace App\UsersBoundedContext\Application;

use App\UsersBoundedContext\Domain\UserRepository;

class GetAllActiveUsersWithAustrianCitizenship
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): GetAllActiveUsersWithAustrianCitizenshipResponse
    {
        $users = $this->repository->findAllActiveWithAustrianCitizenship();
        $response = new GetAllActiveUsersWithAustrianCitizenshipResponse();
        foreach ($users as $user) {
            $response->add($user);
        }

        return $response;
    }
}
