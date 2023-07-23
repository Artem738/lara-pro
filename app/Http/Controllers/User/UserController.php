<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCheckIdRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Repositories\User\DTO\UserStoreDTO;
use App\Repositories\User\DTO\UserUpdateDTO;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();

        // Якщо перенести це у сервіси, то як повертати помилку, якщо там ітератор?
        if (auth()->attempt($data) === false) {
            return response("Email or Password incorrect", 422);
        }

        $loginData = $this->userService->loginUser($data);

        return response(new UserResource($loginData), 200);
    }

    public function index()
    {
        $data = $this->userService->getAllUsers();
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

        $userIterator = $this->userService->store($userDTO);
        $userResource = new UserResource($userIterator);


        return response()->json(
            [
                'data' => $userResource,
                'meta' => [
                    'info' => $valid['name'] . ", welcome to API. Save your key.",
                ],
            ], 201
        );

    }

    public function show(UserCheckIdRequest $request)
    {
        $valid = $request->validated();
        $userIterator = $this->userService->getUserById($valid['id']);
        $userResource = new UserResource($userIterator);
        return response($userResource, 200);
    }

    public function update(UserUpdateRequest $request)
    {
        $valid = $request->validated();
        //$userData = $this->userService->getUserById($valid['id']);
        $userUpdateDTO = new UserUpdateDTO(
            $valid['id'],
            $valid['name'],
            Carbon::now(),
        );

        $userIterator = $this->userService->updateUser($userUpdateDTO);
        return response(new UserResource($userIterator), 200);
    }

    public function destroy(UserCheckIdRequest $request)
    {
        $valid = $request->validated();
        if ($this->userService->deleteUser($valid['id'])) {
            return response()->json(['message' => 'User id - ' . $valid['id'] . ' deleted successfully']);
        }

        return response()->json(
            ['message' => 'User id - ' . $valid['id'] . ' delete failure or no user.'],
            422 // 422 - Unprocessable Entity
        );
    }
}
