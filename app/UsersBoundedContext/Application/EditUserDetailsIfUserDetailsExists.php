<?php

namespace App\UsersBoundedContext\Application;

use App\UsersBoundedContext\Domain\UserRepository;

class EditUserDetailsIfUserDetailsExists
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EditUserDetailsIfUserDetailsExistsRequest $request): EditUserDetailsIfUserDetailsExistsResponse
    {
        $user = $this->repository->find($request->getUserId());
        if (!$user->hasUserDetails()) {

            return new EditUserDetailsIfUserDetailsExistsResponse(false);
        }

        $this->repository->save($user);

        return new EditUserDetailsIfUserDetailsExistsResponse(true);
    }
}
