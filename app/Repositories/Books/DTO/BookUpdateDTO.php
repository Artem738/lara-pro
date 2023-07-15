<?php

namespace App\Repositories\Books\DTO;

use Carbon\Carbon;

class BookUpdateDTO
{
    public function __construct(
        protected int    $id,
        protected string $name,
        protected int    $year,
        protected string $lang,
        protected int    $pages,
        protected Carbon $created_at,
        protected Carbon $updated_at,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
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

