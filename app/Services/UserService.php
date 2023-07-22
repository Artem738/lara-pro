<?php

namespace App\Services;

use App\Repositories\User\Iterators\UserIterator;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function getUserById(int $id):UserIterator {
        return $this->userRepository->getUserById($id);

    }

    public function getAllUsers(): Collection
    {
        return $this->usersRepository->getAllUsers();
    }

    public function store(UserStoreDTO $userDTO): UserIterator
    {
        $userId = $this->usersRepository->store($userDTO);
        return $this->usersRepository->getUserById($userId);
    }


    public function updateUser($userUpdateDTO): UserIterator
    {
        $isUpdated = $this->usersRepository->updateUser($userUpdateDTO);
        if ($isUpdated == null) {
            throw new Exception('Failed to update user.');
        }
        return $this->usersRepository->getUserById($userUpdateDTO->getId());
    }

    public function deleteUser($id): bool
    {
        return $this->usersRepository->deleteUser($id);
    }

}
