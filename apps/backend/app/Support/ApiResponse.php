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
        if ($status < 200 || $status >= 300) {
            $status = 200; // Default to 200 if an invalid status code is provided
        }

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
        if ($status < 400 || $status >= 600) {
            $status = 500; // Default to 500 if an invalid status code is provided
        }

        $response = ['success' => false, 'message' => $message];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}
