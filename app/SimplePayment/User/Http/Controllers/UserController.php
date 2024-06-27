<?php

namespace SimplePayment\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use SimplePayment\User\Http\Requests\CreateUserRequest;
use SimplePayment\User\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function createUser(CreateUserRequest $request)
    {
        return $this->userService->createUser($request->toDTO());
    }
}
