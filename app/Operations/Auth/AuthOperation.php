<?php

namespace App\Operations\Auth;

use App\Dtos\Auth\LoginDto;
use App\Dtos\Auth\RegisterDto;
use App\Models\User;
use App\Operations\User\UserOperations;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class AuthOperation
{
    public function __construct(
        protected UserOperations $userOperations,
        protected TokenOperation $tokenOperation
    )
    {
    }

    /**
     * @param RegisterDto $registrationDto
     * @return array
     * @throws AuthenticationException
     */
    public function register(RegisterDto $registrationDto): array
    {
        $user = $this->userOperations->createUser($registrationDto);

        $accessToken = $this->tokenOperation->createAccessToken($user);
        $refreshToken = $this->tokenOperation->createRefreshToken($user);

        return [$accessToken, $refreshToken];
    }

    /**
     * @param LoginDto $loginDto
     * @return array
     * @throws AuthenticationException
     */
    public function login(LoginDto $loginDto): array
    {
        $user = User::where('email', $loginDto->email)->first();

        if(!$user) {
            throw new AuthenticationException('user not found');
        }

        if (!Hash::check($loginDto->password, $user->password)) {
            throw new AuthenticationException('login failed');
        }

        $accessToken = $this->tokenOperation->createAccessToken($user);
        $refreshToken = $this->tokenOperation->createRefreshToken($user);

        return [$accessToken, $refreshToken];
    }

    /**
     * @throws \Exception
     */
    public function refreshTokens(): array
    {
        $user = $this->userOperations->getAuthUser();
        $this->tokenOperation->dropUserTokens($user);
        $accessToken = $this->tokenOperation->createAccessToken($user);
        $refreshToken = $this->tokenOperation->createRefreshToken($user);

        return [$accessToken, $refreshToken];
    }

}
