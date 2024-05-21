<?php

namespace App\Contracts\Exceptions\Exceptions;

use App\Contracts\Enums\ApiResponseEnum;
use App\Contracts\Exceptions\ApiExceptionResponseAbstract;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class AuthenticationExceptionHandler extends ApiExceptionResponseAbstract
{
    public function __construct(AuthenticationException $exception)
    {
        $this->exception = $exception;
        $this->statusCode = ApiResponseEnum::AUTHENTICATION_FAILED;
    }

    public function __invoke(): JsonResponse
    {
        $message = "Unauthenticated";

        return $this->error($message, $this->getStatusCode());
    }
}
