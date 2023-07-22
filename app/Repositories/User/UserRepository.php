<?php

namespace App\Repositories\User;

use App\Repositories\User\Iterators\UserLoginIterator;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function getById(int $id): UserLoginIterator
    {
        return new UserLoginIterator(
            DB::table('users')
                ->where('id', '=', $id)
                ->first()
        );
    }
}
