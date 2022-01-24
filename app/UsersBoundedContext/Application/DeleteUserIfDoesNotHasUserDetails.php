<?php

namespace App\UsersBoundedContext\Application;

use App\UsersBoundedContext\Domain\UserRepository;

class DeleteUserIfDoesNotHasUserDetails
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteUserIfDoesNotHasUserDetailsRequest $request): DeleteUserIfDoesNotHasUserDetailsResponse
    {
        $user = $this->repository->find($request->getUserId());
        if (!$user->hasUserDetails()) {

            return new DeleteUserIfDoesNotHasUserDetailsResponse(false);
        }
        $this->repository->delete($user);

        return new DeleteUserIfDoesNotHasUserDetailsResponse(true);
    }
}
