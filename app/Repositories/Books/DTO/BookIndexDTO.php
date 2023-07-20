<?php

namespace App\Repositories\Books\DTO;

use App\Enum\LangEnum;
use App\Enum\LimitEnum;
use Carbon\Carbon;

class BookIndexDTO
{
    public function __construct(
        protected Carbon $startDate,
        protected Carbon $endDate,
        protected ?int    $year,
        protected ?LangEnum $lang,
        protected int $lastId,
        protected int $limit,
    ) {
    }

    /**
     * @return int
     */
    public function getLastId(): int
    {
        return $this->lastId;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        if (!in_array($this->limit, array_column(LimitEnum::cases(), 'value'))) {
            return  10; // LimitEnum::LIMIT_10;
        }
        return $this->limit;
    }

    /**
     * @return Carbon
     */
    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    /**
     * @return Carbon
     */
    public function getEndDate(): Carbon
    {
        return $this->endDate;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function getLang(): ?LangEnum
    {
        return $this->lang;
    }

}
