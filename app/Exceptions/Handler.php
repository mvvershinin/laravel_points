<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use InvalidArgumentException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        if ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        /** Форматируем все ошибки роутов API */
        if ($request->is('api/*')) {
            $e = $this->prepareException($e);
            if ($e instanceof InvalidArgumentException) {
                $e = new BadRequestHttpException($e->getMessage(), $e);
            }

            return $this->buildJsonResponse($e);
        }

        return parent::render($request, $e);
    }

    protected function buildJsonResponse(Throwable $e): JsonResponse
    {
        return new JsonResponse(
            $this->convertExceptionToArray($e),
            $this->getExceptionStatusCode($e),
            $e instanceof HttpExceptionInterface ? $e->getHeaders() : [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        );
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request): JsonResponse|Response
    {
        if ($e->response) {
            return $e->response;
        }

        return new JsonResponse([
            'status'    => 'error',
            'errorCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'details'   => $e->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    protected function convertExceptionToArray(Throwable $e): array
    {
        return [
            'status'    => 'error',
            'errorCode' => $this->getExceptionStatusCode($e),
            'details'   => [
                'error' => $e->getMessage(),
            ],
        ];
    }

    protected function getExceptionStatusCode(Throwable $exception): int
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        if ($exception instanceof AuthenticationException) {
            return Response::HTTP_UNAUTHORIZED;
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
