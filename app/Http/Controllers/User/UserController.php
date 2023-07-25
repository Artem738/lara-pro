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
    // https://uk.wikipedia.org/wiki/Список_кодів_стану_HTTP
    public function __construct(
        protected UserService $userService
    ) {
    }
    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();

        if ($this->userService->checkUserAuthDataWithoutLogin($data) === false) {
            return response("Email or Password incorrect", 401); // 401 Unauthorized
        }

        $user = $this->userService->loginValidatedUser($data);

        return response()->json(
            [
                'data' => new UserResource($user),
                'Bearer' => $this->userService->createToken(),
                'meta' => [
                    'info' => $user->getName() . ", welcome to API. Save your key.",
                ],
            ], 200
        );
    }
    public function index()
    {
        $allUsers = $this->userService->getAllUsers();

        return response()->json(
            [
                'data' => UserResource::collection($allUsers),
                'meta' => [
                    'info' => "All users data shown...",
                ],
            ], 200
        );
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $userDTO = new UserStoreDTO(
            $data['name'],
            $data['email'],
            Hash::make($data['password']),
            Carbon::now(),
            Carbon::now()
        );

        $userIterator = $this->userService->storeUser($userDTO);

        return response()->json(
            [
                'data' => new UserResource($userIterator),
                'Bearer' => $this->userService->createToken(),
                'meta' => [
                    'info' => $data['name'] . ", - new user created. Token shown",
                ],
            ], 201
        );

    }

    public function show(UserCheckIdRequest $request)
    {
        $data = $request->validated();
        $userIterator = $this->userService->getUserById($data['id']);

        return response()->json(
            [
                'data' => new UserResource($userIterator),
                'Bearer' => $this->userService->createToken(),
                'meta' => [
                    'info' => $userIterator->getName() . ", just exist in Database",
                ],
            ], 200
        );
    }

    public function update(UserUpdateRequest $request)
    {
        $data = $request->validated();
        $userUpdateDTO = new UserUpdateDTO(
            $data['id'],
            $data['name'],
            Carbon::now(),
        );

        $userIterator = $this->userService->updateUser($userUpdateDTO);

        return response()->json(
            [
                'data' => new UserResource($userIterator),
                'Bearer' => $this->userService->createToken(),
                'meta' => [
                    'info' => $userIterator->getName() . ", - User update Successful",
                ],
            ], 202 // 202 Accepted — Прийнято
        );
    }

    public function destroy(UserCheckIdRequest $request)
    {
        $data = $request->validated();
        if ($this->userService->deleteUser($data['id'])) {
            return response()->json(
                ['message' => 'User id - ' . $data['id'] . ' User deleted successfully'],
                204 //204 No Content — Немає вмісту , І тому реально message не повертає )))
            );
        }
        return response()->json(
            ['message' => 'User id - ' . $data['id'] . ' delete failure or no user.'],
            422 // 422 - Unprocessable Entity
        );
    }
}
