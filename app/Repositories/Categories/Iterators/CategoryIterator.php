<?php

namespace App\Repositories\Categories\Iterators;

class CategoryIterator
{
    protected int $id;
    protected string $name;

    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
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
