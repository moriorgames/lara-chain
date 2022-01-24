<?php

namespace App\UsersBoundedContext\Domain;

class UserDetails
{
    private int $id;
    private int $citizenshipCountryId;
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;

    public function __construct(
        int    $id,
        int    $citizenshipCountryId,
        string $firstName,
        string $lastName,
        string $phoneNumber
    )
    {
        $this->id = $id;
        $this->citizenshipCountryId = $citizenshipCountryId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCitizenshipCountryId(): int
    {
        return $this->citizenshipCountryId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}
