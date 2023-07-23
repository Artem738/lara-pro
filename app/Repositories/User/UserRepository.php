<?php

namespace App\Repositories\User;

use App\Repositories\User\DTO\UserStoreDTO;
use App\Repositories\User\DTO\UserUpdateDTO;
use App\Repositories\User\Iterators\UserIterator;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository
{

    public function getUserById(int $id): UserIterator
    {
        $userData = DB::table('users')
            ->where('id', $id)
            ->select(
                [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            )
            ->get()
            ->first();

        return new UserIterator($userData);
    }


    public function getAllUsers(): Collection
    {
        $usersData = DB::table('users')
            ->limit(1000)
            ->get();

        $users = collect();

        foreach ($usersData as $userData) {
            $userIterator = new UserIterator($userData);
            $users->push($userIterator);
        }

        return $users;
    }

    public function store(UserStoreDTO $userStoreDTO): int
    {
        $userId = DB::table('users')->insertGetId(
            [
                'name' => $userStoreDTO->getName(),
                'email' => $userStoreDTO->getEmail(),
                'password' => $userStoreDTO->getPassword(),
                'created_at' => $userStoreDTO->getCreatedAt(),
                'updated_at' => $userStoreDTO->getUpdatedAt(),
            ]
        );

        return $userId;
    }

    public function updateUser(UserUpdateDTO $userUpdateDTO): bool
    {
        $updateStatus = DB::table('users')
            ->where('id', $userUpdateDTO->getId())
            ->update([
                         'name' => $userUpdateDTO->getName(),
                         'updated_at' => $userUpdateDTO->getUpdatedAt(),
                     ]);

        return $updateStatus > 0;
    }

    public function deleteUser($id): bool
    {
        $deleted = DB::table('users')->delete($id);
        return $deleted > 0;
    }


}
