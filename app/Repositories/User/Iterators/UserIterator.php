<?php

namespace App\Repositories\User\Iterators;

class UserIterator
{
    protected int $id;
    protected string $name;
    protected string $email;
    protected ?object $token = null;

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
     * @param mixed $token
     */
    public function setToken(?object $token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getToken(): ?object
    {
        return $this->token;
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
