<?php

namespace App\UsersBoundedContext\Domain;

use DateTime;

class User
{
    private int $id;
    private string $email;
    private bool $active;
    private DateTime $created_at;
    private DateTime $updated_at;
    private ?UserDetails $userDetails;

    public function __construct(
        int          $id,
        string       $email,
        bool         $active,
        DateTime     $created_at,
        DateTime     $updated_at,
        ?UserDetails $userDetails = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->active = $active;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->userDetails = $userDetails;
    }

    public function hasUserDetails(): bool
    {
        return ($this->userDetails !== null);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserDetails(): ?UserDetails
    {
        return $this->userDetails;
    }

    public function setUserDetails(UserDetails $userDetails): void
    {
        $this->userDetails = $userDetails;
    }
}
