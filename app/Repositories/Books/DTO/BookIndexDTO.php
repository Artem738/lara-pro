<?php

namespace App\Repositories\Books\DTO;

use App\Enum\LangEnum;
use App\Enum\LimitEnum;
use Carbon\Carbon;

class BookIndexDTO
{
    protected int $startId;

    public function __construct(
        protected Carbon     $startDate,
        protected Carbon     $endDate,
        protected ?int       $year,
        protected ?LangEnum  $lang,
        protected int        $lastId,
        protected LimitEnum $limit,

    ) {
        $this->startId = $this->lastId;
    }

    /**
     * @return int
     */
    public function getStartId(): int
    {
        return $this->startId;
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
    public function getLimit(): LimitEnum
    {
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
