<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

interface ResponseContract
{
    /**
     * @param bool $status
     * @param int $code
     * @param array $errors
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function sendJsonResponse(
        bool  $status,
        int   $code = Response::HTTP_OK,
        array $errors = [],
        array $data = [],
        array $additionalData = []
    ): JsonResponse;

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function success(array $data = [], array $additionalData = []): JsonResponse;

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function unSuccess(array $data = [], array $additionalData = []): JsonResponse;

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function created(array $data = [], array $additionalData = []): JsonResponse;

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function badRequest(array $data = [], array $additionalData = []): JsonResponse;

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function unauthorized(array $data = [], array $additionalData = []): JsonResponse;

    /**
     * @param array $data
     * @return JsonResponse
     */
    public static function forbidden(array $data = []): JsonResponse;

    /**
     * @param array $data
     * @return JsonResponse
     */
    public static function notFound(array $data = []): JsonResponse;

    /**
     * @param array $data
     * @return JsonResponse
     */
    public static function unprocessableContent(array $data = []): JsonResponse;
}
