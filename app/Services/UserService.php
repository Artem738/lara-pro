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



        $user = $this->getUserById(auth()->user()->id);
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
        return $this->userRepository->getAllUsers();
    }

    public function store(UserStoreDTO $userDTO): UserIterator
    {
        $userId = $this->userRepository->store($userDTO);
        return $this->userRepository->getUserById($userId);
    }


    public function updateUser(UserUpdateDTO $userUpdateDTO): UserIterator
    {
        $isUpdated = $this->userRepository->updateUser($userUpdateDTO);
        if ($isUpdated == null) {
            throw new Exception('Failed to update user.');
        }
        return $this->userRepository->getUserById($userUpdateDTO->getId());
    }

    public function deleteUser($id): bool
    {
        return $this->userRepository->deleteUser($id);
    }

}
