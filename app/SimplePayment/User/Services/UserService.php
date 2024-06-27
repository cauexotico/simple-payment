<?php

namespace SimplePayment\User\Services;

use App\Models\User;
use SimplePayment\User\DTO\UserDTO;

class UserService
{
    public function __construct()
    {
    }

    public static function createUser(UserDTO $userDTO): User
    {
        $user = new User();
        $user->name = $userDTO->name;
        $user->email = $userDTO->email;
        $user->password = bcrypt($userDTO->password);
        $user->save();

        $user->{$userDTO->type}()->create([
            'document' => $userDTO->document
        ]);

        return $user;
    }
}
