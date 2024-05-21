<?php

namespace App\Contracts\Exceptions\Exceptions;

use App\Contracts\Enums\ApiResponseEnum;
use App\Contracts\Exceptions\ApiExceptionResponseAbstract;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthorizationExceptionHandler extends ApiExceptionResponseAbstract
{
    public function __construct(AccessDeniedHttpException $exception)
    {
        $this->exception = $exception;
        $this->statusCode = ApiResponseEnum::AUTHORIZATION_FAILED;
    }

    public function __invoke(): JsonResponse
    {
        $message = "You don't have permission to access this page.";

        return $this->error($message, $this->getStatusCode());
    }
}
