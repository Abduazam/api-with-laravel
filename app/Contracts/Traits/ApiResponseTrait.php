<?php

namespace App\Contracts\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function success($message, $data = [], $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    protected function error($message, $statusCode): JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message
        ]);
    }
}
