<?php

namespace App\Console\Commands;

use JsonSerializable;

class MyUserData implements JsonSerializable
{
    protected string $name;
    protected int $age;
    protected string $gender;
    protected string $city;
    protected string $phone;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getUserDataString(): string
    {
        $formattedData = "Дані користувача:" . PHP_EOL;
        $formattedData .= "Ім'я: " . $this->getName() . PHP_EOL;
        $formattedData .= "Вік: " . $this->getAge() . PHP_EOL;
        $formattedData .= "Стать: " . $this->getGender() . PHP_EOL;
        $formattedData .= "Місто: " . $this->getCity() . PHP_EOL;
        $formattedData .= "Телефон: " . $this->getPhone() . PHP_EOL;

        return $formattedData;
    }

    public function fillFromArray(array $data): void
    {
        $this->setName($data['name']);
        $this->setAge($data['age']);
        $this->setGender($data['gender']);
        $this->setCity($data['city']);
        $this->setPhone($data['phone']);
    }


    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'age' => $this->getAge(),
            'gender' => $this->getGender(),
            'city' => $this->getCity(),
            'phone' => $this->getPhone(),
        ];
    }
}
