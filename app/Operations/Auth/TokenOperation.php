<?php

namespace App\Operations\Auth;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class TokenOperation
{
    const REFRESH_ACCESS_TOKEN = 'refresh-access-token';
    const ACCESS_API = 'access-api';

    const TOKEN_NAMES = [
        self::ACCESS_API => 'access_token',
        self::REFRESH_ACCESS_TOKEN => 'refresh_token',
    ];

    /**
     * @param User $user
     * @param string $tokenType
     * @return NewAccessToken
     */
    public function createToken(User $user, string $tokenType): NewAccessToken
    {
        return $user->createToken(
            $this->getTokenName($tokenType),
            [$tokenType],
            now()->addMinutes(config('sanctum.expiration'))
        );
    }

    /**
     * @param User $user
     * @return NewAccessToken
     */
    public function createAccessToken(User $user): NewAccessToken
    {
        return $this->createToken($user, self::ACCESS_API);
    }

    /**
     * @param User $user
     * @return NewAccessToken
     */
    public function createRefreshToken(User $user): NewAccessToken
    {
        return $this->createToken($user, self::REFRESH_ACCESS_TOKEN);
    }

    public function dropUserTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    private function getTokenName(string $tokenTypes): string
    {
        return self::TOKEN_NAMES[$tokenTypes];
    }
}
