<?php

namespace App\Services\Response;

use App\Http\Resources\Paginate\PaginateResource;
use App\Services\Contracts\ResponseContract;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseService implements ResponseContract
{
    /**
     * @param bool $status
     * @param int $code
     * @param array $errors
     * @param array $data
     * @param array $additionalData
     * @return array
     */
    private static function responseParams(
        bool  $status,
        int   $code,
        array $errors = [],
        array $data = [],
        array $additionalData = []
    ): array
    {
        $pagination = new PaginateResource($data);

        if (!empty($pagination))
            return [
                'status' => $status,
                'code' => $code,
                'errors' => (object)$errors,
                'data' => isset($data[0]) ? (object)$data[0] : (object)$data,
                'pagination' => $pagination,
                'additional_data' => $additionalData,
            ];
        else
            return [
                'status' => $status,
                'code' => $code,
                'errors' => (object)$errors,
                'data' => isset($data[0]) ? (object)$data[0] : (object)$data,
                'additional_data' => $additionalData,
            ];
    }

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
        array $errors = [], array $data = [],
        array $additionalData = []
    ): JsonResponse
    {
        return response()->json(
            self::responseParams($status, $code, $errors, $data, $additionalData),
        );
    }

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function success(array $data = [], array $additionalData = []): JsonResponse
    {
        return self::sendJsonResponse(true, Response::HTTP_OK, [], $data, $additionalData);
    }

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function unSuccess(array $data = [], array $additionalData = []): JsonResponse
    {
        return self::sendJsonResponse(false, Response::HTTP_OK, [], $data, $additionalData);
    }

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function created(array $data = [], array $additionalData = []): JsonResponse
    {
        return self::sendJsonResponse(true, Response::HTTP_CREATED, [], $data, $additionalData);
    }

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function badRequest(array $data = [], array $additionalData = []): JsonResponse
    {
        return self::sendJsonResponse(false, Response::HTTP_BAD_REQUEST, [], [], $additionalData);
    }

    /**
     * @param array $data
     * @param array $additionalData
     * @return JsonResponse
     */
    public static function unauthorized(array $data = [], array $additionalData = []): JsonResponse
    {
        return self::sendJsonResponse(false, Response::HTTP_UNAUTHORIZED, [], [], $additionalData);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public static function forbidden(array $data = []): JsonResponse
    {
        return self::sendJsonResponse(false, Response::HTTP_FORBIDDEN, $data);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public static function notFound(array $data = []): JsonResponse
    {
        return self::sendJsonResponse(false, Response::HTTP_NOT_FOUND, [], $data);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public static function unprocessableContent(array $data = []): JsonResponse
    {
        return self::sendJsonResponse(false, Response::HTTP_UNPROCESSABLE_ENTITY, [], $data);
    }
}
