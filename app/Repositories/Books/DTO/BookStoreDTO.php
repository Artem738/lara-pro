<?php

namespace App\Repositories\Books\DTO;

use App\Enum\LangEnum;
use Carbon\Carbon;

class BookStoreDTO
{
    public function __construct(
        protected string   $name,
        protected int      $year,
        protected LangEnum $lang,
        protected int      $pages,
        protected Carbon   $created_at,
        protected Carbon   $updated_at,
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

    public function getLang(): LangEnum
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

