<?php

namespace App\Repositories\Books\Iterators;
use Carbon\Carbon;

class BookIterator
{

    protected int $id;
    protected string $name;
    protected int $year;
    protected string $lang;
    protected int $pages;
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
        $this->created_at = new Carbon($data->created_at); // ->toDateTimeString(); /// = Carbon::parse($data->created_at);
        $this->updated_at =new Carbon($data->updated_at); //->toDateTimeString(); //Carbon::parse($data->updated_at);

//        echo "Data received in BookIterator constructor: ";
//        var_dump($data);
//        exit();
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

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }


}
