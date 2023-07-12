<?php

namespace App\DTO;

use Carbon\Carbon;

class BookDTO
{
    public function __construct(
        protected string $name,
        protected int    $year,
        protected string $lang,
        protected int    $pages,
        protected Carbon $updated_at,
        protected Carbon $created_at,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }


}

