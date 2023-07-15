<?php

namespace App\Repositories\Books\DTO;

use App\Enum\LangEnum;
use Carbon\Carbon;

class BookIndexDTO
{
    public function __construct(
        protected Carbon $startDate,
        protected Carbon $endDate,
        protected ?int    $year,
        protected ?LangEnum $lang,
    ) {
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
