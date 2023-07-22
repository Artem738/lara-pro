<?php

namespace App\Repositories\User\DTO;

use App\Enum\LangEnum;
use Carbon\Carbon;

class UserStoreDTO
{
    public function __construct(
        protected string $name,
        protected string $email,
        protected string $password,
        protected Carbon $createdAt,
        protected Carbon $updatedAt,
    ) {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }




}

