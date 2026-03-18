<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Success response
     */
    public static function success($data = null, ?string $message = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => $message,
            'error' => null,
        ], $status);
    }

    /**
     * Error response
     */
    public static function error(string $message, $data = null, int $status = 400): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => null,
            'error' => $message,
        ], $status);
    }
}
