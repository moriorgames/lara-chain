<?php

namespace App\UsersBoundedContext\Application;

class EditUserDetailsIfUserDetailsExistsRequest
{
    private int $userId;
    private int $userDetailCitizenshipCountryId;
    private string $userDetailFirstName;
    private string $userDetailLastName;
    private string $userDetailPhoneNumber;

    public function __construct(
        int    $userId,
        int    $userDetailCitizenshipCountryId,
        string $userDetailFirstName,
        string $userDetailLastName,
        string $userDetailPhoneNumber
    )
    {
        $this->userId = $userId;
        $this->userDetailCitizenshipCountryId = $userDetailCitizenshipCountryId;
        $this->userDetailFirstName = $userDetailFirstName;
        $this->userDetailLastName = $userDetailLastName;
        $this->userDetailPhoneNumber = $userDetailPhoneNumber;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserDetailCitizenshipCountryId(): int
    {
        return $this->userDetailCitizenshipCountryId;
    }

    public function getUserDetailFirstName(): string
    {
        return $this->userDetailFirstName;
    }

    public function getUserDetailLastName(): string
    {
        return $this->userDetailLastName;
    }

    public function getUserDetailPhoneNumber(): string
    {
        return $this->userDetailPhoneNumber;
    }
}
