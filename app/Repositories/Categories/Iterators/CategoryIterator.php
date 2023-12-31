<?php

namespace App\Repositories\Categories\Iterators;

use Carbon\Carbon;

class CategoryIterator
{
    protected int $id;
    protected string $name;
    protected Carbon $updatedAt;
    protected Carbon $createdAt;

    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->createdAt = Carbon::parse($data->created_at);
        $this->updatedAt = Carbon::parse($data->updated_at);
//        $this->created_at = new Carbon($data->created_at);
//        $this->updated_at = new Carbon($data->updated_at); //->toDateTimeString(); //Carbon::parse($data->updated_at);
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
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


}
