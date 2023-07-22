<?php

namespace App\Services;

use App\Repositories\User\Iterators\UserLoginIterator;
use App\Repositories\User\UserRepository;

class UserLoginService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function getById(int $id):UserLoginIterator {
        return $this->userRepository->getById($id);


    }
}
