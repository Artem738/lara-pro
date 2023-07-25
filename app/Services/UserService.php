<?php

namespace App\Services;

use App\Repositories\User\DTO\UserStoreDTO;
use App\Repositories\User\DTO\UserUpdateDTO;
use App\Repositories\User\Iterators\UserIterator;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function getAuthUserId(): int
    {
        // return auth()->user()->id;
        return auth()->id();
    }

    public function createToken()
    {
        return auth()->user()->createToken(config('app.name'));
    }

    public function loginAuthAttempt(array $data): bool
    {
        if (auth()->attempt($data) === false) {
            return false;
        }
        return true;
    }

    public function checkUserAuthDataWithoutLogin(array $data): bool
    {
        if (Auth::validate($data) === false) {  // Я правильно?  auth()->validate()  або так?
            return false;
        }
        return true;
    }

    public function loginValidatedUser(array $data): UserIterator
    {
        if ($this->loginAuthAttempt($data) === false) {
            $this->serviceError("Use loginValidatedUser only on validated User, after checkUserAuthDataWithoutLogin") . PHP_EOL;
        }
        return $this->getUserById($this->getAuthUserId());
    }

    public function getUserById(int $id): UserIterator
    {
        return $this->userRepository->getUserById($id);
    }

    public function getAllUsers(): Collection
    {

        return $this->userRepository->getAllUsers();
    }

    public function storeUser(UserStoreDTO $data): UserIterator
    {
        $userId = $this->userRepository->store($data);
        if($userId == null || $userId  == 0) {
            $this->serviceError('Failed to store a new user data.');
        }
        return $this->userRepository->getUserById($userId);
    }

    public function updateUser(UserUpdateDTO $data): UserIterator
    {

        $isUpdated = $this->userRepository->updateUser($data);
        if ($isUpdated == null) {
            $this->serviceError('Failed to update a user.');
        }
        return $this->userRepository->getUserById($data->getId());
    }

    public function deleteUser($id): bool
    {
        return $this->userRepository->deleteUser($id);
    }

    #[NoReturn] public function serviceError(string $errorMessage, int $errorCode = 422): void
    {
        die(
        response()->json(
            [
                'error' => $errorMessage,
            ], $errorCode // 202 Accepted — Прийнято
        )
        );
    }

}
