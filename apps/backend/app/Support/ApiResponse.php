<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

final class ApiResponse {
    public static function success(
        null|string $message = null,
        null|array $data = null,
        null|array $meta = null,
        int $status = 200
    ): JsonResponse {
        $response = ['success' => true];

        if (!empty($message))
            $response['message'] = $message;
        if (!empty($data))
            $response['data'] = $data;
        if (!empty($meta))
            $response['meta'] = $meta;

        return response()->json($response, $status);
    }

    public static function error(
        string $message,
        int $status = 400,
        array $errors = []
    ): JsonResponse {
        $response = ['success' => false, 'message' => $message];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}
