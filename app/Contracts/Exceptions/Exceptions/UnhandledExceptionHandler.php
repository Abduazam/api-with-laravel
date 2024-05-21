<?php

namespace App\Contracts\Exceptions\Exceptions;

use App\Contracts\Enums\ApiResponseEnum;
use App\Contracts\Exceptions\ApiExceptionResponseAbstract;
use Illuminate\Http\JsonResponse;

class UnhandledExceptionHandler extends ApiExceptionResponseAbstract
{
    public function __construct()
    {
        $this->statusCode = ApiResponseEnum::UNHANDLED;
    }

    public function __invoke(): JsonResponse
    {
        $message = "Unhandled exception";

        return $this->error($message, $this->getStatusCode());
    }
}
