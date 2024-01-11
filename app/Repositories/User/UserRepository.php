<?php

namespace App\Repositories\User;

use App\Dtos\Auth\RegisterDto;
use App\Models\User;

class UserRepository
{
    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(RegisterDto $registerDto): User
    {
        $user = new User();
        $user->email = $registerDto->email;
        $user->password = bcrypt($registerDto->password);
        $user->save();

        return $user;
    }
}
