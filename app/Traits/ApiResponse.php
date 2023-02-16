<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait ApiResponser
 *
 * @package App\Traits
 */
trait ApiResponse
{
    /**
     * @param string|array $message
     * @param array $data
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected function baseResponse(
        string $message,
        array $data,
        int $statusCode
    ): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * @param string $message
     * @param array $data
     *
     * @return JsonResponse
     */
    protected function successResponse(string $message = "", array $data = []): JsonResponse
    {
        return $this->baseResponse(
            $message,
            $data,
            Response::HTTP_OK
        );
    }

    /**
     * @param string|array $message
     * @param array $data
     *
     * @return JsonResponse
     */
    protected function errorResponse(string $message = "", array $data = []): JsonResponse
    {
        return $this->baseResponse(
            $message,
            $data,
            Response::HTTP_BAD_REQUEST
        );
    }
}
