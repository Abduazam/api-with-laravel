<?php

namespace App\Contracts\Exceptions;

use App\Contracts\Exceptions\Exceptions\AuthenticationExceptionHandler;
use App\Contracts\Exceptions\Exceptions\UnhandledExceptionHandler;
use App\Contracts\Exceptions\Exceptions\ValidationExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use App\Contracts\Exceptions\Exceptions\AuthorizationExceptionHandler;
use App\Contracts\Exceptions\Exceptions\ModalNotFoundExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiExceptionHandler
{
    protected array $exceptionHandlers = [
        NotFoundHttpException::class => ModalNotFoundExceptionHandler::class,
        ModelNotFoundException::class => ModalNotFoundExceptionHandler::class,
        AccessDeniedHttpException::class => AuthorizationExceptionHandler::class,
        AuthenticationException::class => AuthenticationExceptionHandler::class,
        ValidationException::class => ValidationExceptionHandler::class,
    ];

    public function handle($throwable): JsonResponse
    {
        foreach ($this->exceptionHandlers as $exceptionClass => $handlerClass) {
            if ($throwable instanceof $exceptionClass) {
                $handler = new $handlerClass($throwable);
                return $handler();
            }
        }

        $handler = new UnhandledExceptionHandler;
        return $handler();
    }
}
