<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class MyUserCommand extends Command
{
    protected $signature = 'myuser {name}';
    protected $description = 'My user Learning Command';

    private string $userDirectoryPath = 'app/users';

    public function handle(): void
    {
        $name = $this->argument('name');

        $userData = new MyUserData();

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

    protected function processUserChoice(MyUserData $userData): void
    {
        $option = $this->choice('Виберіть, що робити:', ['Read', 'Write']);

        if ($option === 'Read') {
            $this->readUserDataFromFile($userData);
        } elseif ($option === 'Write') {
            $this->getUserAdditionalData($userData);
            $this->saveUserDataToFile($userData);
        } else {
            $this->error('Некоректний вибір.');
        }
    }

    protected function getUserAdditionalData(MyUserData $userData): void
    {
        $userData->setGender($this->ask('Введіть вашу стать:'));
        $userData->setCity($this->ask('Введіть ваше місто:'));
        $userData->setPhone($this->ask('Введіть ваш телефон:'));
    }

    protected function readUserDataFromFile(MyUserData $userData): void
    {
        $userFilePath = $this->getUserFilePath($userData->getName());
        if (File::exists($userFilePath)) {
            $contents = File::get($userFilePath);
            $data = json_decode($contents, true);
            $userData->fillFromArray($data);
            $this->info($userData->getUserDataString());
        } else {
            $this->error('Файл не існує.');
        }
    }


    protected function saveUserDataToFile(MyUserData $userData): void
    {
        $json = json_encode($userData);
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
        $directory = storage_path($this->userDirectoryPath);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        return $directory . '/' . $name . '.txt';
    }
}
