<?php

namespace App\Repositories\User\Iterators;

class UserIterator
{
    protected int $id;
    protected string $name;
    protected string $email;


    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->email = $data->email;
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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }


}
