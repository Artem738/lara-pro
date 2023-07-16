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
    protected Carbon $updated_at;
    protected Carbon $created_at;


    /**
     * @param string $name
     */
    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->year = $data->year;
        $this->lang = $data->lang;
        $this->pages = $data->pages;
        $this->category = new CategoryIterator(
            $data->category_id,
            $data->category_name,
        );
        $this->created_at = new Carbon($data->created_at); // ->toDateTimeString(); /// = Carbon::parse($data->created_at);
        $this->updated_at = new Carbon($data->updated_at); //->toDateTimeString(); //Carbon::parse($data->updated_at);

//        echo "Data received in BookIterator constructor: ";
//        var_dump($data);
//        exit();
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
        return $this->updated_at;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }




}
