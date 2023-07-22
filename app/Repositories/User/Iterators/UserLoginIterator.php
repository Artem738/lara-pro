<?php

namespace App\Repositories\User\Iterators;

class UserLoginIterator
{
    protected int $id;
    protected string $email;

    public function __construct(object $data)
    {
    $this->id = $data->id;
    $this->email = $data->email;
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
