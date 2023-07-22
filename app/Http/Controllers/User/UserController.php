<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCheckIdRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Repositories\User\DTO\UserStoreDTO;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        protected UserService $usersService
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
            $this->usersService->getUserById(
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
    public function index()
    {
        $data = $this->usersService->getAllUsers();
        return response(UserResource::collection($data), 200);
    }

    public function store(UserStoreRequest $request)
    {
        $valid = $request->validated();
        $userDTO = new UserStoreDTO(
            $valid['name'],
            $valid['email'],
            Hash::make($valid['password']),
            Carbon::now(),
            Carbon::now()
        );

        $userIterator = $this->usersService->store($userDTO);
        $userResource = new UserResource($userIterator);
        return response($userResource, 201); // 201 - Created
    }

    public function show(UserCheckIdRequest $request)
    {
        $valid = $request->validated();
        $userIterator = $this->usersService->getUserById($valid['id']);
        $userResource = new UserResource($userIterator);
        return response($userResource, 200);
    }

    public function update(UserUpdateRequest $request)
    {
        $valid = $request->validated();
        $userData = $this->usersService->getUserById($valid['id']);
        $userUpdateDTO = new UserUpdateDTO(
            $valid['id'],
            $valid['name'],
            $valid['email'],
            // Add other properties here as needed
            $userData->getCreatedAt(),
            Carbon::now()
        );

        $userIterator = $this->usersService->updateUser($userUpdateDTO);
        return response(new UserResource($userIterator), 200);
    }

    public function destroy(UserCheckIdRequest $request)
    {
        $valid = $request->validated();
        if ($this->usersService->deleteUser($valid['id'])) {
            return response()->json(['message' => 'User id - ' . $valid['id'] . ' deleted successfully']);
        }

        return response()->json(
            ['message' => 'User id - ' . $valid['id'] . ' delete failure or no user.'],
            422 // 422 - Unprocessable Entity
        );
    }
}
