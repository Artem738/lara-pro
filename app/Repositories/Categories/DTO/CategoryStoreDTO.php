<?php

namespace App\Repositories\Categories\DTO;

use App\Enum\LangEnum;
use Carbon\Carbon;

class CategoryStoreDTO
{
    public function __construct(
        protected string $name,
        protected Carbon $createdAt,
        protected Carbon $updatedAt,
    ) {
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

