<?php

use App\Support\ApiResponse;
use App\Support\Result;

if (!function_exists('api')) {
    /**
     * Helper for standardized API responses
     */
    function api(): ApiResponse {
        return new ApiResponse();
    }
}

if (!function_exists('result')) {
    /**
     * Helper for Result factory
     */
    function result(): string {
        return Result::class;
    }
}
