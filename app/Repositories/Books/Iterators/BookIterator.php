<?php

namespace App\Repositories\Books\Iterators;

use App\Repositories\Categories\Iterators\CategoryIterator;
use Carbon\Carbon;

class BookIterator
{

    protected int $id;
    protected string $name;
    protected int $year;
    protected string $lang;
    protected int $pages;
    protected CategoryIterator $category;
    protected Carbon $updatedAt;
    protected Carbon $createdAt;


    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->year = $data->year;
        $this->lang = $data->lang;
        $this->pages = $data->pages;
        $this->category = new CategoryIterator((object) [
            'id' => $data->category_id,
            'name' => $data->category_name,
            'created_at' => $data->category_created_at, // created_at бо ми створюємо!
            'updated_at' => $data->category_updated_at,
        ]);
        $this->createdAt = new Carbon($data->created_at); // ->toDateTimeString(); /// = Carbon::parse($data->created_at);
        $this->updatedAt = new Carbon($data->updated_at); //->toDateTimeString(); //Carbon::parse($data->updated_at);
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
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @return CategoryIterator
     */
    public function getCategory(): CategoryIterator
    {
        return $this->category;
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


}
