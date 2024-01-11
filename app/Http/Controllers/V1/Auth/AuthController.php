<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Operations\Auth\AuthOperation;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthOperation $authOperation
    )
    {

    }
    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $registrationDto = $request->getRegisterDto();

        [$accessToken, $refreshToken] = $this->authOperation->register($registrationDto);

        return new JsonResponse([
            'status' => 'success',
            'token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
        ],
            HttpResponse::HTTP_CREATED
        );
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $loginDto = $request->getLoginDto();

        [$accessToken, $refreshToken] = $this->authOperation->login($loginDto);

        return new JsonResponse(
            [
                'status' => 'success',
                'token' => $accessToken->plainTextToken,
                'refresh_token' => $refreshToken->plainTextToken,
            ],
            HttpResponse::HTTP_ACCEPTED
        );

    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function refreshToken(): JsonResponse
    {
        [$accessToken, $refreshToken] = $this->authOperation->refreshTokens();

        return new JsonResponse(
            [
                'status' => 'success',
                'token' => $accessToken->plainTextToken,
                'refresh_token' => $refreshToken->plainTextToken,
            ],
            HttpResponse::HTTP_ACCEPTED
        );
    }
}
