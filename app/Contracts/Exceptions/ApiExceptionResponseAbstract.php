<?php

namespace App\Contracts\Exceptions;

use App\Contracts\Enums\ApiResponseEnum;
use App\Contracts\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Throwable;

abstract class ApiExceptionResponseAbstract
{
    use ApiResponseTrait;

    protected mixed $exception;
    protected ApiResponseEnum $statusCode;

    abstract public function __invoke(): JsonResponse;

    public function getStatusCode(): int
    {
        return $this->statusCode->value;
    }
}
