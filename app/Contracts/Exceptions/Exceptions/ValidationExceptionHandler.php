<?php

namespace App\Contracts\Exceptions\Exceptions;

use App\Contracts\Enums\ApiResponseEnum;
use App\Contracts\Exceptions\ApiExceptionResponseAbstract;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ValidationExceptionHandler extends ApiExceptionResponseAbstract
{
    public function __construct(ValidationException $exception)
    {
        $this->exception = $exception;
        $this->statusCode = ApiResponseEnum::VALIDATION_FAILED;
    }

    public function __invoke(): JsonResponse
    {
        $errors = [];

        foreach ($this->exception->errors() as $key => $value)
            foreach ($value as $message) {
                $errors[] = [
                    'status' => $this->getStatusCode(),
                    'message' => $message,
                    'source' => $key
                ];
            }

        return $this->error($errors, $this->getStatusCode());
    }
}
