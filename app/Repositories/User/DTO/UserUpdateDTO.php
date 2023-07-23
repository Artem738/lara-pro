<?php

namespace App\Repositories\User\DTO;

use Carbon\Carbon;

class UserUpdateDTO
{
    public function __construct(
        protected int $id,
        protected string $name,
        protected Carbon $updatedAt,
    ) {
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }



}
