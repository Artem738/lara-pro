<?php

namespace App\Repositories\Categories\DTO;

use App\Enum\LangEnum;
use Carbon\Carbon;

class CategoryStoreDTO
{
    public function __construct(
        protected string $name,
        protected Carbon $created_at,
        protected Carbon $updated_at,
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
        return $this->created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }




}

