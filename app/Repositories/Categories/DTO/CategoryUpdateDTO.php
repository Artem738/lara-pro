<?php

namespace App\Repositories\Categories\DTO;

use App\Enum\LangEnum;
use Carbon\Carbon;

class CategoryUpdateDTO
{
    public function __construct(
        protected int $id,
        protected string $name,
        protected Carbon $createdAt,
        protected Carbon $updatedAt,
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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

