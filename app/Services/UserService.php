<?php

namespace App\Services;

use App\Repositories\User\DTO\UserStoreDTO;
use App\Repositories\User\DTO\UserUpdateDTO;
use App\Repositories\User\Iterators\UserIterator;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function createToken()
    {
        return auth()
            ->user()
            ->createToken(config('app.name')); //Якесь секретне слово, а навіщо?
    }

    public function loginUser(array $data): UserIterator
    {

        $user = $this->getUserById(auth()->id());
        $token = $this->createToken();

        // Устанавливаем токен для объекта итератора пользователя
        $user->setToken($token);
        return $user;
    }

    public function getUserById(int $id): UserIterator
    {

        return $this->userRepository->getUserById($id);

    }

    public function getAllUsers(): Collection
    {
        if (auth()->id() != 1) {
            echo("Only SuperAdmin can see all users");
            die();
        }
        return $this->userRepository->getAllUsers();
    }

    public function store(UserStoreDTO $userDTO): UserIterator
    {
        if (auth()->id() != 1) {
            echo("Only SuperAdmin can create any users");
            die();
        }
        $userId = $this->userRepository->store($userDTO);
        return $this->userRepository->getUserById($userId);
    }


    public function updateUser(UserUpdateDTO $userUpdateDTO): UserIterator
    {
        if (auth()->id() != $userUpdateDTO->getId() || auth()->id() != 1) {
            echo("Only SuperAdmin can update any user");
            die();
        }
        $isUpdated = $this->userRepository->updateUser($userUpdateDTO);
        if ($isUpdated == null) {
            throw new Exception('Failed to update user.'); // Як повертати помилки на контроллер?
        }
        return $this->userRepository->getUserById($userUpdateDTO->getId());
    }

    public function deleteUser($id): bool
    {
        if (auth()->id() != 1) {
            echo("Only SuperAdmin can delete users");
            die();
        }
        return $this->userRepository->deleteUser($id);
    }

}
