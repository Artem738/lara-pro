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
        $data = DB::table('users')
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

        return new UserIterator($data);
    }


    public function getAllUsers(): Collection
    {
        $data = DB::table('users')
            ->limit(1000)
            ->get();

        $users = collect();

        foreach ($data as $userData) {
            $userIterator = new UserIterator($userData);
            $users->push($userIterator);
        }

        return $users;
    }

    public function store(UserStoreDTO $data): int
    {
        $userId = DB::table('users')->insertGetId(
            [
                'name' => $data->getName(),
                'email' => $data->getEmail(),
                'password' => $data->getPassword(),
                'created_at' => $data->getCreatedAt(),
                'updated_at' => $data->getUpdatedAt(),
            ]
        );
        // А що тут буде якщо не запишем? Треба повертати помилку...
        return $userId;
    }

    public function updateUser(UserUpdateDTO $data): bool
    {
        $updateStatus = DB::table('users')
            ->where('id', $data->getId())
            ->update([
                         'name' => $data->getName(),
                         'updated_at' => $data->getUpdatedAt(),
                     ]);

        return $updateStatus > 0;
    }

    public function deleteUser($id): bool
    {
        $deleted = DB::table('users')->delete($id);
        return $deleted > 0;
    }


}
