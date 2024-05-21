<?php

namespace App\Contracts\Exceptions\Exceptions;

use App\Contracts\Enums\ApiResponseEnum;
use App\Contracts\Exceptions\ApiExceptionResponseAbstract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModalNotFoundExceptionHandler extends ApiExceptionResponseAbstract
{
    public function __construct(NotFoundHttpException|ModelNotFoundException $exception)
    {
        $this->exception = $exception;
        $this->statusCode = ApiResponseEnum::MODAL_NOT_FOUND;
    }

    public function __invoke(): JsonResponse
    {
        return response()->json([
            'status' => $this->getStatusCode(),
            'message' => "Modal not found",
            'source' => $this->exception instanceof ModelNotFoundException ? $this->exception->getModel() : "",
        ]);
    }
}
