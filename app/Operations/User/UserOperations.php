<?php

namespace App\Operations\User;

use App\Dtos\Auth\RegisterDto;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;

class UserOperations
{
    public function __construct(
        protected UserRepository $userRepository
    )
    {

    }

    public function getAuthUser(): User
    {
        $id = auth('sanctum')->id();

        if(!$id) {
            throw new Exception('not exists auth user');
        }

        return $this->userRepository->getById($id);
    }

    /**
     * @throws AuthenticationException
     */
    public function createUser(RegisterDto $registerDto): User
    {
        $existsUser = $this->userRepository->getByEmail($registerDto->email);
        if ($existsUser) {
            throw new AuthenticationException('user exists');
        }

        return $this->userRepository->create($registerDto);
    }
}
