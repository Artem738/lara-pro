<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserLoginService;

class UserController extends Controller
{
    public function __construct(
        protected UserLoginService $userLoginService
    ) {
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();
        // Додати правила перевірки
        // Перенести у сервіси?
        if (auth()->attempt($data) === false) {
            return response("Email or Password incorrect", 422);
        };

        $token = auth()
            ->user()
            ->createToken(config('app.name')); //Якесь секретне слово, а навіщо?


        //  Підключаємо сервіс та ресурс.

        $userResource = new UserResource(
            $this->userLoginService->getById(
                auth()
                    ->user()->id  //  SOME ERROR ???
            )
        );

        return $userResource->additional(
            [
                'bearer' => $token,
            ]
        );

    }
}
