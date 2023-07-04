<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use JsonSerializable;

class ArtUserData implements JsonSerializable
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


class MyUserCommand extends Command
{
    protected $signature = 'myuser {name}';
    protected $description = 'My user Learning Command';

    public function handle(): void
    {
        $name = $this->argument('name');

        $userData = new ArtUserData();

        $userData->setName($name);
        $userData->setAge($this->ask('Введіть ваш вік:'));

        if ($userData->getAge() < 18) {
            if (!$this->confirm('Ви неповнолітній. Продовжити виконання команди?')) {
                $this->info('Ви скасували виконання команди.');
                return;
            }
        }

        $this->processUserChoice($userData);
    }

    protected function processUserChoice(ArtUserData $userData): void
    {
        $option = $this->choice('Виберіть, що робити:', ['Read', 'Write']);

        if ($option === 'Read') {
            $this->readFile($userData);
        } elseif ($option === 'Write') {
            $this->writeFile($userData);
        } else {
            $this->error('Некоректний вибір.');
        }
    }

    protected function readFile(ArtUserData $userData): void
    {
        $userFilePath = $this->getUserFilePath($userData->getName());
        if (File::exists($userFilePath)) {
            $contents = File::get($userFilePath);
            $this->line($contents);
        } else {
            $this->error('Файл не існує.');
        }
    }

    protected function writeFile(ArtUserData $userData): void
    {
        $this->getUserDataFromUser($userData);
        $json = $this->convertUserDataToJson($userData);
        $this->saveUserDataToFile($userData, $json);
    }

    protected function getUserDataFromUser(ArtUserData $userData): void
    {
        $userData->setGender($this->ask('Введіть вашу стать:'));
        $userData->setCity($this->ask('Введіть ваше місто:'));
        $userData->setPhone($this->ask('Введіть ваш телефон:'));
    }

    protected function convertUserDataToJson(ArtUserData $userData): string
    {
        return json_encode($userData);
    }

    protected function saveUserDataToFile(ArtUserData $userData, string $json): void
    {
        $userFilePath = $this->getUserFilePath($userData->getName());
        $result = File::put($userFilePath, $json);

        if ($result !== false) {
            $this->info('Дані успішно записані у файл.');
        } else {
            $this->error('Помилка при записі даних у файл.');
        }
    }

    protected function getUserFilePath(string $name): string
    {
        $directory = storage_path('app/users');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        return $directory . '/' . $name . '.txt';
    }
}
